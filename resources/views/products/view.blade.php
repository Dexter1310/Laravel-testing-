
<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        {{ __('Product') }}
    </h2>
    <a href="{{route('products.list')}}"><button class="btn btn-dark float-end" id="add-product-btn">{{__('List')}}</button></a>

    <h2>{{__('Name')}}:{{$product[0]->name}}</h2>
    <h2>{{__('Description')}}:</h2>
    <p>{{$product[0]->description}}</p>
    <h2>{{__('Images')}}</h2>
    <table class="table">
        <thead>
        <th>{{__('Name')}}</th>
        <th>{{__('image')}}</th>
        </thead>
        <tbody>
        @foreach($product as $image)
            <tr>
                @if($image->image_path)
                    <td>
                        {{$image->image_name}}
                    </td>
                    <td>
                        <a href="{{url('storage/'.$image->image_path)}}" target="_blank">
                            <img src="{{url('storage/'.$image->image_path)}}"
                                 alt="{{$image->image_name}}" width="100"/></a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</x-slot>
</x-app-layout>
