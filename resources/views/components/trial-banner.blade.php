@if(isset($currentBusiness))
    @if($currentBusiness->isTrialActive())
        <div class="bg-gradient-to-r from-neutral-900 via-neutral-850 to-neutral-900 border-b border-amber-800/40 px-4 py-2.5 sm:px-6">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-xs">
                <div class="flex items-center space-x-2.5 text-neutral-300">
                    <span class="flex h-2 w-2 rounded-full bg-amber-400 ring-4 ring-amber-400/20 animate-pulse"></span>
                    <span>
                        <strong class="text-white">{{ __('app.trial_banner_title') }}:</strong>
                        {{ __('app.trial_banner_desc', ['date' => $currentBusiness->trial_ends_at ? $currentBusiness->trial_ends_at->format('M d, Y') : '']) }}
                    </span>
                </div>
                <div class="flex items-center space-x-3 flex-shrink-0">
                    <a href="{{ route('app.subscription.index') }}"
                       class="font-semibold text-neutral-950 bg-amber-400 hover:bg-amber-300 px-3 py-1 rounded text-xs transition shadow-sm">
                        {{ __('app.upgrade_plan') }}
                    </a>
                </div>
            </div>
        </div>
    @elseif($currentBusiness->isTrialExpired() && !$currentBusiness->hasActiveSubscription())
        <div class="bg-red-950/90 border-b border-red-800 px-4 py-3 sm:px-6">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                <div class="flex items-center space-x-2.5 text-red-200">
                    <i data-lucide="alert-octagon" class="w-5 h-5 text-red-400 flex-shrink-0"></i>
                    <span>
                        <strong class="text-white">{{ __('app.subscription_expired_title') }}:</strong>
                        {{ __('app.subscription_expired_desc') }}
                    </span>
                </div>
                <div class="flex items-center space-x-3 flex-shrink-0">
                    <a href="{{ route('app.subscription.index') }}"
                       class="font-semibold text-white bg-red-600 hover:bg-red-500 px-3.5 py-1.5 rounded text-xs transition shadow-sm">
                        {{ __('app.upgrade_plan') }}
                    </a>
                </div>
            </div>
        </div>
    @endif
@endif
