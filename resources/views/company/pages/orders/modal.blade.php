      <div class="modal fade text-start" id="modalUpdateStatus" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <form id="updateStatusForm" method="post" action="">
                    @method('post')
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel1">{{ __('orders.dialog.change_status_title') }}</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <h3>{{ __('orders.are_you_sure_change_status') }}</h3>
                                <input type="hidden" name="order_id" id="order_id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit"
                                    class="btn btn-sm btn-danger">{{ __('orders.dialog.confirm') }}</button>
                            <button type="button" class="btn btn-sm btn-primary"
                                    data-bs-dismiss="modal">{{ __('orders.dialog.cancel') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>