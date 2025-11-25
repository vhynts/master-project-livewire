@props(['options', 'model', 'label' => '', 'placeholder' => 'Select option'])

<div x-data="{
    open: false,
    search: '',
    selected: @entangle($model).live,
    options: {{ json_encode($options) }},
    get filteredOptions() {
        if (this.search === '') return this.options;
        return this.options.filter(option => 
            option.label.toLowerCase().includes(this.search.toLowerCase())
        );
    },
    select(value) {
        this.selected = value;
        this.open = false;
        this.search = '';
    },
    get selectedLabel() {
        const option = this.options.find(o => o.value == this.selected);
        return option ? option.label : '{{ $placeholder }}';
    },
    init() {
        this.$watch('selected', value => {
            if (!value) this.search = '';
        });
    }
}" class="relative" @click.outside="open = false">
    
    {{-- Label --}}
    @if($label)
        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    @endif

    {{-- Trigger Button --}}
    <button 
        @click="open = !open" 
        type="button" 
        class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-left text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 flex justify-between items-center shadow-xs"
    >
        <span x-text="selectedLabel" :class="{'text-gray-500': !selected, 'text-gray-900': selected}"></span>
        <svg class="h-4 w-4 text-gray-400 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    {{-- Dropdown Menu --}}
    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-50 mt-1 w-full bg-white shadow-lg rounded-lg border border-gray-200 max-h-60 overflow-hidden flex flex-col"
        style="display: none;"
    >
        {{-- Search Input --}}
        <div class="p-2 border-b border-gray-100 bg-gray-50">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input 
                    x-model="search" 
                    type="text" 
                    class="block w-full pl-9 pr-3 py-1.5 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm" 
                    placeholder="Search..."
                    @click.stop
                >
            </div>
        </div>
        
        {{-- Options List --}}
        <ul class="flex-1 overflow-y-auto py-1">
            {{-- Default/Clear Option --}}
            <li 
                @click="select('')" 
                class="px-3 py-2 text-sm text-gray-500 hover:bg-gray-50 cursor-pointer flex justify-between items-center border-b border-gray-50"
            >
                <span>{{ $placeholder }}</span>
            </li>

            <template x-for="option in filteredOptions" :key="option.value">
                <li 
                    @click="select(option.value)" 
                    class="px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 cursor-pointer flex justify-between items-center"
                    :class="{'bg-blue-50 text-blue-600 font-medium': selected == option.value}"
                >
                    <span x-text="option.label"></span>
                    <svg x-show="selected == option.value" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </li>
            </template>
            
            <li x-show="filteredOptions.length === 0" class="px-3 py-4 text-sm text-gray-500 text-center">
                No results found.
            </li>
        </ul>
    </div>
</div>