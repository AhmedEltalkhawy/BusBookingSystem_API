@php $name='ahmed' ; $books= ['php' , 'css']; @endphp
<!-- @php $books= ['php' , 'css']; @endphp -->


{{$name}}

@foreach($books as $book)
    {{$book}}
@endforeach

<a href="{{ route('i.index', ['no' => 1]) }}"> bgrt</a>
<a href="test3/{{$name}}"> bgrt222</a>

