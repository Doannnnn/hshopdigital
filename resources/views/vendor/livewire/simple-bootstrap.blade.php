@php
if (! isset($scrollTo)) {
$scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
? "document.querySelector('{$scrollTo}').scrollIntoView();"
: '';
@endphp

<div>
    @if ($paginator->hasPages())
    <nav aria-label="Page navigation" class="d-flex justify-content-center">
        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link"><i class="tf-icon bx bx-chevrons-left"></i></span>
            </li>
            @else
            <li class="page-item">
                <button type="button" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="page-link" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" aria-label="@lang('pagination.previous')"><i class="tf-icon bx bx-chevrons-left"></i></button>
            </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
            <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
            @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
            <li class="page-item active" wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}" aria-current="page"><span class="page-link">{{ $page }}</span></li>
            @else
            <li class="page-item" wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}"><button type="button" class="page-link" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}">{{ $page }}</button></li>
            @endif
            @endforeach
            @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
            <li class="page-item">
                <button type="button" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="page-link" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" aria-label="@lang('pagination.next')"><i class="tf-icon bx bx-chevrons-right"></i></button>
            </li>
            @else
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link" aria-hidden="true"><i class="tf-icon bx bx-chevrons-right"></i></span>
            </li>
            @endif
        </ul>
    </nav>

    {{-- Small screen pagination info --}}
    <div class="d-sm-none text-center mt-2">
        <p class="small text-muted">
            {!! __('Showing') !!}
            <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
            {!! __('to') !!}
            <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
            {!! __('of') !!}
            <span class="fw-semibold">{{ $paginator->total() }}</span>
            {!! __('results') !!}
        </p>
    </div>
    @endif
</div>