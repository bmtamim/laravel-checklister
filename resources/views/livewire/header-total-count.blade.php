<div class="card">
    <div class="card-header">
        {{ __('Store Review') }}
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    @foreach($checklists as $checklist)
                        @if($checklist->tasks_count > 0)
                            <div class="col-md-3">
                                <strong>{{ $checklist->name }}</strong>
                                <h4><strong>{{ $checklist->user_tasks_count }} / {{ $checklist->tasks_count }}</strong>
                                </h4>
                                <div class="progress progress-xs mt-2">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         style="width: {{ ($checklist->user_tasks_count/ $checklist->tasks_count) * 100 }}%"
                                         aria-valuenow="{{ ($checklist->user_tasks_count/ $checklist->tasks_count) * 100 }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100"></div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-lg-3">
                <h4><b>Total</b></h4>
                <h2><b>{{ $checklists->sum('user_tasks_count') }} / {{ $checklists->sum('tasks_count') }}</b></h2>
            </div>
        </div>

    </div>
</div>
