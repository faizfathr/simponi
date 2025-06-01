@aware([
    'itemSelected',
    'isSubItem' => FALSE,
    'subItemSelected' => [],
    'href' => '#'
])
<li x-data="{dropdown: {{ collect($subItemSelected)->pluck('subLink')->contains(request()->url()) ? 'true' : 'false' }}}">
    <a
      href="{{ $isSubItem ? '#' : $href }}"
        @if($isSubItem)
            @click.prevent="dropdown=!dropdown"
        @else
            wire:navigate
        @endif
      class="flex py-2 rounded-md   relative {{ request()->url() === $href || collect($subItemSelected)->pluck('subLink')->contains(request()->url()) ? 'fill-primary bg-brand-50 text-brand-500 dark:bg-brand-500/[0.12]' : 'hover:bg-gray-200 text-gray-500 dark:hover:bg-gray-800' }}"
    >
        <div class="mx-2">
            {{ $slot ? $slot : '' }}
        </div>
        <span
            class="menu-item-text font-semibold text-sm items-center"
            :class="sidebarToggle ? 'lg:hidden' : ''"
        >
            {{ $itemSelected }}
        </span>
        @if ($isSubItem)
            <svg
                class="menu-item-arrow  stroke-current absolute mx-auto right-8 transition-all duration-200 "
                :class="[dropdown ? 'rotate-180' : '-rorate-180', sidebarToggle ? 'lg:hidden' : '' ]"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                stroke=""
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round"
                />
            </svg>
        @endif
    </a>

    <!-- Dropdown Menu Start -->
    @if ($isSubItem)
        <div
            class="translate transform overflow-hidden"
            :class="dropdown ? 'block' : 'hidden'"
        >
        <ul
            :class="sidebarToggle ? 'lg:hidden' : 'flex'"
            class="menu-dropdown mt-2 flex flex-col gap-1 pl-9"
        >

        @foreach ($subItemSelected as $subItem)
            <li>
                <a
                href="{{ $subItem['subLink'] }}" wire:navigate
                class="menu-dropdown-item group block p-2 rounded-md {{ request()->url() === $subItem['subLink'] ? 'dark:bg-brand-500/[0.12] fill-primary text-primary bg-brand-50' : 'dark:hover:bg-gray-800 hover:bg-gray-200 text-gray-500' }}"
                >
                {{ $subItem['title'] }}
                </a>
            </li>
        @endforeach
        </ul>
        </div>
    @endif
    <!-- Dropdown Menu End -->
  </li>