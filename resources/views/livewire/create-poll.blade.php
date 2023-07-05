<div>
    @inject('flashMessage', '\App\Services\FlashMessageSuccess')
    @if ($msg = $flashMessage->getSuccess())
        <x-ui.alert message="{{$msg}}" class="alert-success"/>
    @endif

    <form wire:submit.prevent="createPoll">
        <div class="mb-4">
            <x-ui.input
                label="Poll title"
                model="title"
                wire:loading.attr="disabled"
                wire:target="createPoll"/>
        </div>
        <div class="flex justify-between">
            <h4 class="text-lg">Poll options</h4>
            <x-ui.button
                class="btn"
                text="Add option"
                loader_target="addOption"
                wire:target="removeOption,createPoll,addOption"
                wire:loading.attr="disabled"
                wire:click.prevent="addOption"/>
        </div>
        @error('options') <span class="error">{{ $message }}</span> @enderror
        <div class="mt-4 mb-4">
            @foreach($options as $index => $option)
                <div class="flex items-start gap-4">
                    <div class="grow mb-4">
                        <x-ui.input
                            model="options.{{ $index }}"
                            wire:key="option-{{ $index }}"
                            placeholder="Option {{ $index + 1 }} text here"
                            wire:loading.attr="disabled"
                            wire:target="createPoll"
                        />
                    </div>
                    <div class="flex-none mb-4">
                        <x-ui.button
                            text="Remove"
                            class="btn"
                            wire:loading.attr="disabled"
                            wire:target="createPoll,removeOption"
                            wire:click.prevent="removeOption({{ $index }})"
                            loader_target="removeOption({{ $index }})"/>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="w-full">
            <x-ui.button
                text="Add Poll"
                class="btn w-full"
                wire:target="removeOption,createPoll,addOption"
                wire:loading.attr="disabled"
                loader_target="removeOption,createPoll,addOption"/>
        </div>
    </form>
</div>
