<div class="modal fade" id="addTasksModal" tabindex="-1" aria-labelledby="{{ $labelledby }}" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $labelledby }}">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addTasksForm" action="{{ $action }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="">
                <div class="card border-0 shadow-lg p-3">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class='bx bx-add-to-queue'></i>
                            {{ $cardTitle }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="task_name" class="form-label">Task</label>
                            <input type="text" name="task_name" id="task_name" placeholder="Enter task" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="attachment">Attachment</label>
                            <div>
                                <div class="input-group control-group add-more mt-2">
                                    <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
                                </div>
                            </div>
                        </div>
                        {{ $slot }}
                    </div>
                </div>
                <div class="modal-footer">


                    {{-- <x-cancel-btn class="mt-3 float-end ms-3 mx-3">Cancel</x-cancel-btn> --}}
                    <x-reset-btn class="mt-3 float-end" />
                    <x-submit-btn class="mt-3 float-end ms-2" id="save" name="submit">Add</x-submit-btn>
                </div>
            </form>
        </div>
    </div>
</div>
