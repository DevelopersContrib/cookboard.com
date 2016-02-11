<?php
namespace app\components;
use Yii;
use yii\base\Component;


class Z extends Component
{
    public function init(){

    }
    
    public function create_url_slug($string){
        $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        return $slug;
    }
    
    public function alert($msg){
        return '<div id="main-notify" role="alert" class="alert alert-warning alert-dismissible alert-custom alert-custom-tl">'.
            '<button data-dismiss="alert" class="close" type="button">'.
                '<span aria-hidden="true">×</span>'.
                '<span class="sr-only">Close</span>'.
            '</button>'.$msg.
        '</div>';
    }
    
    public function hiddenCsrfToken(){
        return '<input type="hidden" name="_csrf" value="'.Yii::$app->request->getCsrfToken().'">';
    }
    
    public function method($string, $whiteSpace = '', $replaceSpace = false, $toLower = false)
    {
        if($toLower)
            $string = strtolower($string);
        if($replaceSpace):
            $string = str_replace(array(' ','_'), '-', $string);
            return preg_replace('/[^a-zA-Z0-9\-' . $whiteSpace . ']/', '', (string) trim($string));
        else:
            return preg_replace('/[^a-zA-Z0-9' . $whiteSpace . ']/', '', (string) trim($string));
        endif;
    }
    
    public function validator($form,
        $items = [
            'id'=>'',
            'clsContainer'=>'',
            'requiredMsg'=>'Cannot be blank.',
            'dtype'=>'string',
            'dtMsg'=>'Cannot be blank.',
            'max'=>10, 
            'maxMsg'=> 'Should contain at most 10 characters.'
        ]
    ){
        $str = 'jQuery("'.$form.'").yiiActiveForm(
        [';
        foreach($items as $item){
            $str .= '{
                "id":"'.$item['id'].'",
                "name":"'.$item['id'].'",
                "container":".'.$item['clsContainer'].'",
                "input":"#'.$item['id'].'",
                "validate":function (attribute, value, messages, deferred) {
                    yii.validation.required(value, messages, {"message":"'.$item['requiredMsg'].'"});
                ';
            if($item['dtype']=='string'){
                $str .= 'yii.validation.string(value, messages, {"message":"'.$item['dtMsg'].'","max":'.$item['max'].',"tooLong":"'.$item['maxMsg'].'","skipOnEmpty":1});';
            }elseif($item['dtype']=='number'){
                $str .= 'yii.validation.number(value, messages, {"pattern":/^\s*[+-]?\d+\s*$/,"message":"'.$item['dtMsg'].'","skipOnEmpty":1});';
            }
            $str .='}'.
            '}';
        }
        return $str.'], []);';
    }
    
}
