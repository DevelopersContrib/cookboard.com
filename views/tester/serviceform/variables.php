<?
$domain = $_SERVER["HTTP_HOST"];
$domain = str_replace("http://","",$domain);
$domain = str_replace("www.","",$domain);

$parnershiptypes = array('Sponsorship Marketing Partnerships','Distribution Marketing Partnerships','Affiliate Marketing Partnerships','Added Value Marketing Partnerships');

$rolesarray = array (
  0 => 
  array (
    'role_id' => '24',
    'role_name' => 'Advisor',
  ),
  1 => 
  array (
    'role_id' => '30',
    'role_name' => 'Co-founder',
  ),
  2 => 
  array (
    'role_id' => '7',
    'role_name' => 'Content Manager',
  ),
  3 => 
  array (
    'role_id' => '29',
    'role_name' => 'Domain Owner',
  ),
  4 => 
  array (
    'role_id' => '25',
    'role_name' => 'Engineer',
  ),
  5 => 
  array (
    'role_id' => '21',
    'role_name' => 'Execution Officer',
  ),
  6 => 
  array (
    'role_id' => '14',
    'role_name' => 'Graphics UI',
  ),
  7 => 
  array (
    'role_id' => '17',
    'role_name' => 'Lead Developer',
  ),
  8 => 
  array (
    'role_id' => '15',
    'role_name' => 'Marketer',
  ),
  9 => 
  array (
    'role_id' => '23',
    'role_name' => 'Mentor',
  ),
  10 => 
  array (
    'role_id' => '11',
    'role_name' => 'Owner',
  ),
  11 => 
  array (
    'role_id' => '12',
    'role_name' => 'Partner',
  ),
  12 => 
  array (
    'role_id' => '27',
    'role_name' => 'Partner Manager',
  ),
  13 => 
  array (
    'role_id' => '31',
    'role_name' => 'Press/Marketing Relations',
  ),
  14 => 
  array (
    'role_id' => '1',
    'role_name' => 'Project Manager',
  ),
  15 => 
  array (
    'role_id' => '26',
    'role_name' => 'Revenue Officer',
  ),
  16 => 
  array (
    'role_id' => '16',
    'role_name' => 'Social and Media ',
  ),
  17 => 
  array (
    'role_id' => '9',
    'role_name' => 'Tester',
  ),
  18 => 
  array (
    'role_id' => '28',
    'role_name' => 'Venture Leader',
  ),
  19 => 
  array (
    'role_id' => '8',
    'role_name' => 'Web Developer',
  ),
);

$industriesarray = array (
  0 => 
  array (
    'IndustryId' => '6',
    'Name' => 'Admin Support',
  ),
  1 => 
  array (
    'IndustryId' => '12',
    'Name' => 'Autos',
  ),
  2 => 
  array (
    'IndustryId' => '14',
    'Name' => 'Business Services',
  ),
  3 => 
  array (
    'IndustryId' => '19',
    'Name' => 'Computer and Technology',
  ),
  4 => 
  array (
    'IndustryId' => '5',
    'Name' => 'Design & Multimedia',
  ),
  5 => 
  array (
    'IndustryId' => '17',
    'Name' => 'Education',
  ),
  6 => 
  array (
    'IndustryId' => '4',
    'Name' => 'Engineering & Manufacturing',
  ),
  7 => 
  array (
    'IndustryId' => '10',
    'Name' => 'Events and Parties',
  ),
  8 => 
  array (
    'IndustryId' => '7',
    'Name' => 'Finance & Management',
  ),
  9 => 
  array (
    'IndustryId' => '13',
    'Name' => 'Fitness and Recreation',
  ),
  10 => 
  array (
    'IndustryId' => '11',
    'Name' => 'Healthcare and Beauty',
  ),
  11 => 
  array (
    'IndustryId' => '18',
    'Name' => 'Home Care and Services',
  ),
  12 => 
  array (
    'IndustryId' => '8',
    'Name' => 'Legal',
  ),
  13 => 
  array (
    'IndustryId' => '9',
    'Name' => 'Real Estate',
  ),
  14 => 
  array (
    'IndustryId' => '2',
    'Name' => 'Sales & Marketing',
  ),
  15 => 
  array (
    'IndustryId' => '15',
    'Name' => 'Staffing and Jobs',
  ),
  16 => 
  array (
    'IndustryId' => '16',
    'Name' => 'Travel',
  ),
  17 => 
  array (
    'IndustryId' => '1',
    'Name' => 'Web & Programming',
  ),
  18 => 
  array (
    'IndustryId' => '3',
    'Name' => 'Writing & Translation',
  ),
);

 
$countriesarray = array (
  0 => 
  array (
    'country_id' => '2',
    'name' => 'Afghanistan',
  ),
  1 => 
  array (
    'country_id' => '3',
    'name' => 'Albania',
  ),
  2 => 
  array (
    'country_id' => '4',
    'name' => 'Algeria',
  ),
  3 => 
  array (
    'country_id' => '5',
    'name' => 'American Samoa',
  ),
  4 => 
  array (
    'country_id' => '6',
    'name' => 'Andorra',
  ),
  5 => 
  array (
    'country_id' => '7',
    'name' => 'Angola',
  ),
  6 => 
  array (
    'country_id' => '8',
    'name' => 'Anguilla',
  ),
  7 => 
  array (
    'country_id' => '9',
    'name' => 'Antarctica',
  ),
  8 => 
  array (
    'country_id' => '10',
    'name' => 'Antigua And Barbuda',
  ),
  9 => 
  array (
    'country_id' => '11',
    'name' => 'Argentina',
  ),
  10 => 
  array (
    'country_id' => '12',
    'name' => 'Armenia',
  ),
  11 => 
  array (
    'country_id' => '13',
    'name' => 'Aruba',
  ),
  12 => 
  array (
    'country_id' => '14',
    'name' => 'Australia',
  ),
  13 => 
  array (
    'country_id' => '15',
    'name' => 'Austria',
  ),
  14 => 
  array (
    'country_id' => '16',
    'name' => 'Azerbaijan',
  ),
  15 => 
  array (
    'country_id' => '17',
    'name' => 'Bahamas',
  ),
  16 => 
  array (
    'country_id' => '18',
    'name' => 'Bahrain',
  ),
  17 => 
  array (
    'country_id' => '19',
    'name' => 'Bangladesh',
  ),
  18 => 
  array (
    'country_id' => '20',
    'name' => 'Barbados',
  ),
  19 => 
  array (
    'country_id' => '200',
    'name' => 'Belarus',
  ),
  20 => 
  array (
    'country_id' => '21',
    'name' => 'Belgium',
  ),
  21 => 
  array (
    'country_id' => '22',
    'name' => 'Belize',
  ),
  22 => 
  array (
    'country_id' => '23',
    'name' => 'Benin',
  ),
  23 => 
  array (
    'country_id' => '24',
    'name' => 'Bermuda',
  ),
  24 => 
  array (
    'country_id' => '25',
    'name' => 'Bhutan',
  ),
  25 => 
  array (
    'country_id' => '26',
    'name' => 'Bolivia',
  ),
  26 => 
  array (
    'country_id' => '27',
    'name' => 'Bosnia and Herzegovina',
  ),
  27 => 
  array (
    'country_id' => '28',
    'name' => 'Botswana',
  ),
  28 => 
  array (
    'country_id' => '29',
    'name' => 'Brazil',
  ),
  29 => 
  array (
    'country_id' => '30',
    'name' => 'British Indian Ocean Territory',
  ),
  30 => 
  array (
    'country_id' => '201',
    'name' => 'British Virgin Islands',
  ),
  31 => 
  array (
    'country_id' => '31',
    'name' => 'Brunei Darussalam',
  ),
  32 => 
  array (
    'country_id' => '32',
    'name' => 'Bulgaria',
  ),
  33 => 
  array (
    'country_id' => '33',
    'name' => 'Burkina Faso',
  ),
  34 => 
  array (
    'country_id' => '34',
    'name' => 'Burundi',
  ),
  35 => 
  array (
    'country_id' => '35',
    'name' => 'Cambodia',
  ),
  36 => 
  array (
    'country_id' => '36',
    'name' => 'Cameroon',
  ),
  37 => 
  array (
    'country_id' => '37',
    'name' => 'Canada',
  ),
  38 => 
  array (
    'country_id' => '38',
    'name' => 'Cape Verde',
  ),
  39 => 
  array (
    'country_id' => '39',
    'name' => 'Cayman Islands',
  ),
  40 => 
  array (
    'country_id' => '40',
    'name' => 'Central African Republic',
  ),
  41 => 
  array (
    'country_id' => '41',
    'name' => 'Chad',
  ),
  42 => 
  array (
    'country_id' => '42',
    'name' => 'Chile',
  ),
  43 => 
  array (
    'country_id' => '43',
    'name' => 'China',
  ),
  44 => 
  array (
    'country_id' => '44',
    'name' => 'Christmas Island',
  ),
  45 => 
  array (
    'country_id' => '45',
    'name' => 'Cocos (Keeling) Islands',
  ),
  46 => 
  array (
    'country_id' => '46',
    'name' => 'Colombia',
  ),
  47 => 
  array (
    'country_id' => '202',
    'name' => 'Comoros',
  ),
  48 => 
  array (
    'country_id' => '203',
    'name' => 'Congo Brazzaville',
  ),
  49 => 
  array (
    'country_id' => '204',
    'name' => 'Congo Democratic Republic',
  ),
  50 => 
  array (
    'country_id' => '205',
    'name' => 'Cook Islands',
  ),
  51 => 
  array (
    'country_id' => '47',
    'name' => 'Costa Rica',
  ),
  52 => 
  array (
    'country_id' => '206',
    'name' => 'Cote d Ivoire',
  ),
  53 => 
  array (
    'country_id' => '48',
    'name' => 'Croatia (Hrvatska)',
  ),
  54 => 
  array (
    'country_id' => '207',
    'name' => 'Cuba',
  ),
  55 => 
  array (
    'country_id' => '49',
    'name' => 'Cyprus',
  ),
  56 => 
  array (
    'country_id' => '50',
    'name' => 'Czech Republic',
  ),
  57 => 
  array (
    'country_id' => '51',
    'name' => 'Denmark',
  ),
  58 => 
  array (
    'country_id' => '52',
    'name' => 'Djibouti',
  ),
  59 => 
  array (
    'country_id' => '53',
    'name' => 'Dominica',
  ),
  60 => 
  array (
    'country_id' => '54',
    'name' => 'Dominican Republic',
  ),
  61 => 
  array (
    'country_id' => '55',
    'name' => 'East Timor',
  ),
  62 => 
  array (
    'country_id' => '56',
    'name' => 'Ecuador',
  ),
  63 => 
  array (
    'country_id' => '57',
    'name' => 'Egypt',
  ),
  64 => 
  array (
    'country_id' => '58',
    'name' => 'El Salvador',
  ),
  65 => 
  array (
    'country_id' => '59',
    'name' => 'Equatorial Guinea',
  ),
  66 => 
  array (
    'country_id' => '60',
    'name' => 'Eritrea',
  ),
  67 => 
  array (
    'country_id' => '61',
    'name' => 'Estonia',
  ),
  68 => 
  array (
    'country_id' => '62',
    'name' => 'Ethiopia',
  ),
  69 => 
  array (
    'country_id' => '63',
    'name' => 'Faroe Islands',
  ),
  70 => 
  array (
    'country_id' => '64',
    'name' => 'Fiji',
  ),
  71 => 
  array (
    'country_id' => '65',
    'name' => 'Finland',
  ),
  72 => 
  array (
    'country_id' => '66',
    'name' => 'France',
  ),
  73 => 
  array (
    'country_id' => '67',
    'name' => 'French Guiana',
  ),
  74 => 
  array (
    'country_id' => '68',
    'name' => 'French Polynesia',
  ),
  75 => 
  array (
    'country_id' => '69',
    'name' => 'Gabon',
  ),
  76 => 
  array (
    'country_id' => '70',
    'name' => 'Gambia',
  ),
  77 => 
  array (
    'country_id' => '71',
    'name' => 'Georgia',
  ),
  78 => 
  array (
    'country_id' => '72',
    'name' => 'Germany',
  ),
  79 => 
  array (
    'country_id' => '73',
    'name' => 'Ghana',
  ),
  80 => 
  array (
    'country_id' => '74',
    'name' => 'Gibraltar',
  ),
  81 => 
  array (
    'country_id' => '75',
    'name' => 'Greece',
  ),
  82 => 
  array (
    'country_id' => '76',
    'name' => 'Greenland',
  ),
  83 => 
  array (
    'country_id' => '77',
    'name' => 'Grenada',
  ),
  84 => 
  array (
    'country_id' => '78',
    'name' => 'Guadeloupe',
  ),
  85 => 
  array (
    'country_id' => '79',
    'name' => 'Guam',
  ),
  86 => 
  array (
    'country_id' => '80',
    'name' => 'Guatemala',
  ),
  87 => 
  array (
    'country_id' => '81',
    'name' => 'Guinea',
  ),
  88 => 
  array (
    'country_id' => '238',
    'name' => 'Guinea Bissau',
  ),
  89 => 
  array (
    'country_id' => '82',
    'name' => 'Guyana',
  ),
  90 => 
  array (
    'country_id' => '83',
    'name' => 'Haiti',
  ),
  91 => 
  array (
    'country_id' => '84',
    'name' => 'Holy See (Vatican City State)',
  ),
  92 => 
  array (
    'country_id' => '85',
    'name' => 'Honduras',
  ),
  93 => 
  array (
    'country_id' => '86',
    'name' => 'Hong Kong SAR, PRC',
  ),
  94 => 
  array (
    'country_id' => '87',
    'name' => 'Hungary',
  ),
  95 => 
  array (
    'country_id' => '88',
    'name' => 'Iceland',
  ),
  96 => 
  array (
    'country_id' => '89',
    'name' => 'India',
  ),
  97 => 
  array (
    'country_id' => '90',
    'name' => 'Indonesia',
  ),
  98 => 
  array (
    'country_id' => '208',
    'name' => 'Iran',
  ),
  99 => 
  array (
    'country_id' => '209',
    'name' => 'Iraq',
  ),
  100 => 
  array (
    'country_id' => '91',
    'name' => 'Ireland',
  ),
  101 => 
  array (
    'country_id' => '92',
    'name' => 'Israel',
  ),
  102 => 
  array (
    'country_id' => '210',
    'name' => 'Isreal',
  ),
  103 => 
  array (
    'country_id' => '93',
    'name' => 'Italy',
  ),
  104 => 
  array (
    'country_id' => '94',
    'name' => 'Jamaica',
  ),
  105 => 
  array (
    'country_id' => '95',
    'name' => 'Japan',
  ),
  106 => 
  array (
    'country_id' => '96',
    'name' => 'Jordan',
  ),
  107 => 
  array (
    'country_id' => '97',
    'name' => 'Kazakhstan',
  ),
  108 => 
  array (
    'country_id' => '98',
    'name' => 'Kenya',
  ),
  109 => 
  array (
    'country_id' => '211',
    'name' => 'Kiribati',
  ),
  110 => 
  array (
    'country_id' => '99',
    'name' => 'Korea, Republic of',
  ),
  111 => 
  array (
    'country_id' => '100',
    'name' => 'Kuwait',
  ),
  112 => 
  array (
    'country_id' => '101',
    'name' => 'Kyrgyzstan',
  ),
  113 => 
  array (
    'country_id' => '102',
    'name' => 'Lao, People\'s Dem. Rep.',
  ),
  114 => 
  array (
    'country_id' => '239',
    'name' => 'Laos',
  ),
  115 => 
  array (
    'country_id' => '103',
    'name' => 'Latvia',
  ),
  116 => 
  array (
    'country_id' => '104',
    'name' => 'Lebanon',
  ),
  117 => 
  array (
    'country_id' => '105',
    'name' => 'Lesotho',
  ),
  118 => 
  array (
    'country_id' => '212',
    'name' => 'Liberia',
  ),
  119 => 
  array (
    'country_id' => '106',
    'name' => 'Libya',
  ),
  120 => 
  array (
    'country_id' => '107',
    'name' => 'Liechtenstein',
  ),
  121 => 
  array (
    'country_id' => '108',
    'name' => 'Lithuania',
  ),
  122 => 
  array (
    'country_id' => '109',
    'name' => 'Luxembourg',
  ),
  123 => 
  array (
    'country_id' => '110',
    'name' => 'Macau',
  ),
  124 => 
  array (
    'country_id' => '111',
    'name' => 'Macedonia',
  ),
  125 => 
  array (
    'country_id' => '112',
    'name' => 'Madagascar',
  ),
  126 => 
  array (
    'country_id' => '113',
    'name' => 'Malawi',
  ),
  127 => 
  array (
    'country_id' => '114',
    'name' => 'Malaysia',
  ),
  128 => 
  array (
    'country_id' => '115',
    'name' => 'Maldives',
  ),
  129 => 
  array (
    'country_id' => '116',
    'name' => 'Mali',
  ),
  130 => 
  array (
    'country_id' => '117',
    'name' => 'Malta',
  ),
  131 => 
  array (
    'country_id' => '118',
    'name' => 'Marshall Islands',
  ),
  132 => 
  array (
    'country_id' => '119',
    'name' => 'Martinique',
  ),
  133 => 
  array (
    'country_id' => '120',
    'name' => 'Mauritania',
  ),
  134 => 
  array (
    'country_id' => '121',
    'name' => 'Mauritius',
  ),
  135 => 
  array (
    'country_id' => '213',
    'name' => 'Mayotte',
  ),
  136 => 
  array (
    'country_id' => '122',
    'name' => 'Mexico',
  ),
  137 => 
  array (
    'country_id' => '214',
    'name' => 'Micronesia',
  ),
  138 => 
  array (
    'country_id' => '123',
    'name' => 'Moldova, Republic Of',
  ),
  139 => 
  array (
    'country_id' => '124',
    'name' => 'Monaco',
  ),
  140 => 
  array (
    'country_id' => '125',
    'name' => 'Mongolia',
  ),
  141 => 
  array (
    'country_id' => '126',
    'name' => 'Montenegro',
  ),
  142 => 
  array (
    'country_id' => '127',
    'name' => 'Montserrat',
  ),
  143 => 
  array (
    'country_id' => '128',
    'name' => 'Morocco',
  ),
  144 => 
  array (
    'country_id' => '129',
    'name' => 'Mozambique',
  ),
  145 => 
  array (
    'country_id' => '215',
    'name' => 'Myanmar',
  ),
  146 => 
  array (
    'country_id' => '130',
    'name' => 'Namibia',
  ),
  147 => 
  array (
    'country_id' => '216',
    'name' => 'Nauru',
  ),
  148 => 
  array (
    'country_id' => '131',
    'name' => 'Nepal',
  ),
  149 => 
  array (
    'country_id' => '132',
    'name' => 'Netherlands',
  ),
  150 => 
  array (
    'country_id' => '133',
    'name' => 'Netherlands Antilles',
  ),
  151 => 
  array (
    'country_id' => '134',
    'name' => 'New Caledonia',
  ),
  152 => 
  array (
    'country_id' => '135',
    'name' => 'New Zealand',
  ),
  153 => 
  array (
    'country_id' => '136',
    'name' => 'Nicaragua',
  ),
  154 => 
  array (
    'country_id' => '137',
    'name' => 'Niger',
  ),
  155 => 
  array (
    'country_id' => '138',
    'name' => 'Nigeria',
  ),
  156 => 
  array (
    'country_id' => '217',
    'name' => 'Niue Island',
  ),
  157 => 
  array (
    'country_id' => '139',
    'name' => 'Norfolk Island',
  ),
  158 => 
  array (
    'country_id' => '218',
    'name' => 'North Mariana Islands',
  ),
  159 => 
  array (
    'country_id' => '140',
    'name' => 'Norway',
  ),
  160 => 
  array (
    'country_id' => '141',
    'name' => 'Oman',
  ),
  161 => 
  array (
    'country_id' => '142',
    'name' => 'Pakistan',
  ),
  162 => 
  array (
    'country_id' => '219',
    'name' => 'Palau',
  ),
  163 => 
  array (
    'country_id' => '143',
    'name' => 'Palestine',
  ),
  164 => 
  array (
    'country_id' => '144',
    'name' => 'Panama',
  ),
  165 => 
  array (
    'country_id' => '220',
    'name' => 'Papua New Guinea',
  ),
  166 => 
  array (
    'country_id' => '145',
    'name' => 'Paraguay',
  ),
  167 => 
  array (
    'country_id' => '146',
    'name' => 'Peru',
  ),
  168 => 
  array (
    'country_id' => '147',
    'name' => 'Philippines',
  ),
  169 => 
  array (
    'country_id' => '148',
    'name' => 'Poland',
  ),
  170 => 
  array (
    'country_id' => '149',
    'name' => 'Portugal',
  ),
  171 => 
  array (
    'country_id' => '150',
    'name' => 'Puerto Rico ',
  ),
  172 => 
  array (
    'country_id' => '151',
    'name' => 'Qatar',
  ),
  173 => 
  array (
    'country_id' => '152',
    'name' => 'Reunion',
  ),
  174 => 
  array (
    'country_id' => '153',
    'name' => 'Romania',
  ),
  175 => 
  array (
    'country_id' => '154',
    'name' => 'Russia',
  ),
  176 => 
  array (
    'country_id' => '155',
    'name' => 'Rwanda',
  ),
  177 => 
  array (
    'country_id' => '156',
    'name' => 'Saint Kitts And Nevis',
  ),
  178 => 
  array (
    'country_id' => '157',
    'name' => 'Saint Lucia',
  ),
  179 => 
  array (
    'country_id' => '158',
    'name' => 'Saint Vincent And the Grenadines',
  ),
  180 => 
  array (
    'country_id' => '159',
    'name' => 'Samoa',
  ),
  181 => 
  array (
    'country_id' => '160',
    'name' => 'San Marino',
  ),
  182 => 
  array (
    'country_id' => '221',
    'name' => 'Sao Tome and Principe',
  ),
  183 => 
  array (
    'country_id' => '161',
    'name' => 'Saudi Arabia',
  ),
  184 => 
  array (
    'country_id' => '162',
    'name' => 'Senegal',
  ),
  185 => 
  array (
    'country_id' => '163',
    'name' => 'Serbia',
  ),
  186 => 
  array (
    'country_id' => '164',
    'name' => 'Seychelles',
  ),
  187 => 
  array (
    'country_id' => '165',
    'name' => 'Sierra Leone',
  ),
  188 => 
  array (
    'country_id' => '166',
    'name' => 'Singapore',
  ),
  189 => 
  array (
    'country_id' => '167',
    'name' => 'Slovak Republic',
  ),
  190 => 
  array (
    'country_id' => '168',
    'name' => 'Slovenia',
  ),
  191 => 
  array (
    'country_id' => '222',
    'name' => 'Solomon Islands',
  ),
  192 => 
  array (
    'country_id' => '223',
    'name' => 'Somalia',
  ),
  193 => 
  array (
    'country_id' => '169',
    'name' => 'South Africa',
  ),
  194 => 
  array (
    'country_id' => '224',
    'name' => 'South Korea',
  ),
  195 => 
  array (
    'country_id' => '170',
    'name' => 'Spain',
  ),
  196 => 
  array (
    'country_id' => '171',
    'name' => 'Sri Lanka',
  ),
  197 => 
  array (
    'country_id' => '225',
    'name' => 'St Kitts and Nevis',
  ),
  198 => 
  array (
    'country_id' => '226',
    'name' => 'St Lucia',
  ),
  199 => 
  array (
    'country_id' => '227',
    'name' => 'St Vincent',
  ),
  200 => 
  array (
    'country_id' => '172',
    'name' => 'St. Pierre And Miquelon',
  ),
  201 => 
  array (
    'country_id' => '228',
    'name' => 'Sudan',
  ),
  202 => 
  array (
    'country_id' => '173',
    'name' => 'Suriname',
  ),
  203 => 
  array (
    'country_id' => '174',
    'name' => 'Swaziland',
  ),
  204 => 
  array (
    'country_id' => '175',
    'name' => 'Sweden',
  ),
  205 => 
  array (
    'country_id' => '176',
    'name' => 'Switzerland',
  ),
  206 => 
  array (
    'country_id' => '229',
    'name' => 'Syria',
  ),
  207 => 
  array (
    'country_id' => '177',
    'name' => 'Taiwan',
  ),
  208 => 
  array (
    'country_id' => '178',
    'name' => 'Tajikistan',
  ),
  209 => 
  array (
    'country_id' => '179',
    'name' => 'Tanzania, United Republic Of',
  ),
  210 => 
  array (
    'country_id' => '180',
    'name' => 'Thailand',
  ),
  211 => 
  array (
    'country_id' => '181',
    'name' => 'Togo',
  ),
  212 => 
  array (
    'country_id' => '182',
    'name' => 'Tonga',
  ),
  213 => 
  array (
    'country_id' => '183',
    'name' => 'Trinidad And Tobago',
  ),
  214 => 
  array (
    'country_id' => '230',
    'name' => 'Trinidad Tobago',
  ),
  215 => 
  array (
    'country_id' => '184',
    'name' => 'Tunisia',
  ),
  216 => 
  array (
    'country_id' => '185',
    'name' => 'Turkey',
  ),
  217 => 
  array (
    'country_id' => '186',
    'name' => 'Turkmenistan',
  ),
  218 => 
  array (
    'country_id' => '187',
    'name' => 'Turks And Caicos Islands',
  ),
  219 => 
  array (
    'country_id' => '231',
    'name' => 'Tuvalu',
  ),
  220 => 
  array (
    'country_id' => '188',
    'name' => 'Uganda',
  ),
  221 => 
  array (
    'country_id' => '189',
    'name' => 'Ukraine',
  ),
  222 => 
  array (
    'country_id' => '190',
    'name' => 'United Arab Emirates',
  ),
  223 => 
  array (
    'country_id' => '191',
    'name' => 'United Kingdom',
  ),
  224 => 
  array (
    'country_id' => '1',
    'name' => 'United States',
  ),
  225 => 
  array (
    'country_id' => '192',
    'name' => 'Uruguay',
  ),
  226 => 
  array (
    'country_id' => '232',
    'name' => 'US Virgin Islands',
  ),
  227 => 
  array (
    'country_id' => '193',
    'name' => 'Uzbekistan',
  ),
  228 => 
  array (
    'country_id' => '233',
    'name' => 'Vanuatu',
  ),
  229 => 
  array (
    'country_id' => '194',
    'name' => 'Venezuela',
  ),
  230 => 
  array (
    'country_id' => '195',
    'name' => 'Vietnam',
  ),
  231 => 
  array (
    'country_id' => '197',
    'name' => 'Virgin Islands',
  ),
  232 => 
  array (
    'country_id' => '196',
    'name' => 'Virgin Islands (British)',
  ),
  233 => 
  array (
    'country_id' => '234',
    'name' => 'Wake Midway Island',
  ),
  234 => 
  array (
    'country_id' => '235',
    'name' => 'Wallis and Futuna',
  ),
  235 => 
  array (
    'country_id' => '198',
    'name' => 'Yemen',
  ),
  236 => 
  array (
    'country_id' => '199',
    'name' => 'Zambia',
  ),
  237 => 
  array (
    'country_id' => '236',
    'name' => 'Zimbabwe',
  ),
);
?>