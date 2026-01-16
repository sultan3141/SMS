<div class="space-y-4 p-4">
    @forelse($logs as $log)
        <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
            <div class="flex-shrink-0">
                @if($log->action === 'created')
                    <x-heroicon-o-plus-circle class="w-6 h-6 text-success-500" />
                @elseif($log->action === 'updated')
                    <x-heroicon-o-pencil-square class="w-6 h-6 text-warning-500" />
                @elseif($log->action === 'submitted')
                    <x-heroicon-o-check-circle class="w-6 h-6 text-primary-500" />
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $log->action_label }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $log->created_at->format('M d, Y H:i') }}
                    </p>
                </div>
                <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    @if($log->action === 'created')
                        <span>Initial score: <strong>{{ $log->new_score }}</strong></span>
                    @elseif($log->action === 'updated')
                        <span>Changed from <strong>{{ $log->old_score }}</strong> to <strong>{{ $log->new_score }}</strong></span>
                    @elseif($log->action === 'submitted')
                        <span>Mark finalized with score: <strong>{{ $log->new_score }}</strong></span>
                    @endif
                </div>
                @if($log->teacher)
                    <p class="mt-1 text-xs text-gray-400">
                        By: {{ $log->teacher->name }}
                    </p>
                @endif
                @if($log->reason)
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 italic">
                        "{{ $log->reason }}"
                    </p>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center text-gray-500 py-8">
            <x-heroicon-o-clock class="w-12 h-12 mx-auto text-gray-300" />
            <p class="mt-2">No change history available</p>
        </div>
    @endforelse
</div>
