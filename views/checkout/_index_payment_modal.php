<div class="modal fade payment-type" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Select Payment</h4>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <label>
                          Payment Type
                        </label>
                        <div class="form-group">
                            <label class="sr-only">Payment Type</label>
                            <select class="form-control" id="payment-type" >
                                <option value="1">PayPal Express Checkout</option>
                                <option value="2">POD (Payment on Delivery)</option>
                            </select>
                            <input id="selected-order" value="" type="hidden" />
                        </div>
                    </li>
                    <li class="list-group-item">
                        <label>
                          Order Notes
                        </label>
                        <div class="form-group">
                            <label class="sr-only">Order Notes</label>
                            <textarea id="order-notes" name="order-notes" class="form-control"></textarea>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button id="continue-submit" type="button" class="btn btn-warning">Submit</button>
            </div>
          </div>
    </div>
</div>
