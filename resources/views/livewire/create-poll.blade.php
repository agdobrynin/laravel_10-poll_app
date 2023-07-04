<div>
    <form wire:submit.prevent="createPoll">
        <div class="mb-4">
            <label>Poll title</label>
            <input type="text"
                   wire:loading.attr="disabled"
                   wire:target="createPoll"
                   wire:model="title"
                @class(['border-red-500' => $errors->has('title')])>
            @error('title') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="flex justify-between">
            <h4 class="text-lg">Poll options</h4>
            <button class="btn"
                    wire:target="removeOption,createPoll,addOption"
                    wire:loading.attr="disabled"
                    wire:click.prevent="addOption">
                Add option
                <span wire:loading wire:target="addOption">
                    <x-ui.loader/>
                </span>
            </button>
        </div>
        @error('options') <span class="error">{{ $message }}</span> @enderror
        <div class="mt-4 mb-4">
            @foreach($options as $index => $option)
                <div class="flex items-start gap-4">
                    <div class="grow mb-4">
                        <input type="text"
                               wire:key="option-{{ $index }}"
                               wire:loading.attr="disabled"
                               wire:target="createPoll"
                               wire:model="options.{{ $index }}"
                            @class(['border-red-500' => $errors->has('options.'.$index)])
                        >
                        @error('options.'.$index) <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex-none mb-4">
                        <button class="btn"
                                wire:loading.attr="disabled"
                                wire:target="createPoll,removeOption"
                                wire:click.prevent="removeOption({{ $index }})">
                            Remove
                            <span wire:loading wire:target="removeOption({{ $index }})">
                                <x-ui.loader/>
                            </span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="w-full">
            <button type="submit"
                    class="btn w-full"
                    wire:target="removeOption,createPoll,addOption"
                    wire:loading.attr="disabled">
                Add Poll
                <span wire:loading wire:target="removeOption,createPoll,addOption">
                    <x-ui.loader/>
                </span>
            </button>
        </div>
    </form>
</div>
