@if( isset($content_information['buttons']) )

        @forelse( $content_information['buttons'] as $button)

            <div class="col-lg-2 col-sm-4 col-xs-12 pull-right">

                @if( isset($button['url']) )

                    <a href="{{ $button['url'] }}">

                        <button class="btn btn-block btn-outline {{ $button['class'] }}" onclick="{{ $button['js'] or '' }}">{{ $button['name'] }}</button>

                    </a>

                @else

                    <button class="btn btn-block btn-outline {{ $button['class'] }}" onclick="{{ $button['js'] or '' }}">{{ $button['name'] }}</button>

                @endif

            </div>

        @empty

        @endforelse

@endif
