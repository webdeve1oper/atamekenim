<div class="modal fade" id="finish_help" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Одобрить запрос {{ $help->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin_finish_help') }}" method="post">
                    @csrf
                    <input type="text" name="help_id" class="d-none" value="{{ $help->id }}">
                    <div class="form-check my-3 border-bottom pb-3">
                        <textarea class="form-control" name="body" placeholder="Комментарий"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success mt-4 mx-auto d-table">Исполнить</button>
                </form>
            </div>
        </div>
    </div>
</div>
