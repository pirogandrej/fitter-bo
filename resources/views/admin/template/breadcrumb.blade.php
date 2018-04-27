@if( isset($content_information['breadcrumb']) )

    <ol class="breadcrumb">

        <li><a href="{{ route('admin_users') }}">Главная</a></li>

        @forelse( $content_information['breadcrumb'] as $segment)

            <li class="{{ $segment['status'] }}"><a href="{{ $segment['url'] }}">{{ $segment['name'] }}</a></li>

        @empty

            <li>---</li>

        @endforelse

    </ol>

@endif