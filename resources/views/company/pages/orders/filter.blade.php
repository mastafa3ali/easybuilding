<button type="button" class="btn btn-sm btn-outline-primary bg-white me-1 waves-effect border-0" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">
<i data-feather='zoom-in'></i>
<span class="active-sorting text-primary">{{ __('books.advanced_filter') }}</span>
<i data-feather='chevron-right'></i>
</button>
<div class="modal modal-slide-in fade" id="filterModal">
<div class="modal-dialog sidebar-sm">
    <div class="add-new-record modal-content pt-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
        <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">{{ __('books.advanced_filter') }}</h5>
        </div>
        <div class="modal-body flex-grow-1 text-start">
            <form id="filterForm" class="">
                <div class="row">
                    <div class="mb-1 col-md-12 pl-0">
                        <label class="form-label" for="book_name">{{ __('books.book_name') }}</label>
                        <input type="text" name="book_name" id="book_name" class="form-control" placeholder="{{ __('books.book_name') }}"/>
                    </div>

                    <div class="mb-1 col-md-12 pl-0">
                        <label class="form-label" for="student_phone">{{ __('books.student_phone') }}</label>
                        <input type="text" name="student_phone" id="student_phone" class="form-control" placeholder="{{ __('books.student_phone') }}"/>
                    </div>
                        <div class="mb-1 col-md-12 pl-0">
                        <label class="form-label" for="number">{{ __('books.order_number') }}</label>
                        <input type="number" name="number" id="number" class="form-control" placeholder="{{ __('books.order_number') }}"/>
                    </div>
                    <div class="mb-1 col-md-12 pl-0">
                            <label class="form-label" for="date">{{ __('books.date') }}</label>
                        <input type="date" name="date" id="date" class="form-control clearable"
                                placeholder="{{ __('books.date') }}"/>
                    </div>
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary btn_filter">{{ __('books.search') }}</button>
                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                            {{ __('books.cancel') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

