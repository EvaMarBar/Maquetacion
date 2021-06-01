<div class="shirt">

    <div class="shirt-title">
        <h3>{{isset($shirt->seo->title) ? $shirt->seo->title : ""}}</h3>
    </div>
    
    <div class="shirt-specifies">
        <div class="shirt-description">
            <div class="shirt-description-text">
                {!!isset($shirt->locale['description']) ? $shirt->locale['description'] : "" !!}
            </div>
        </div>
        <div class="shirt-specifications">
            @isset($shirt->product_number)
                <div class="shirt-specifications-product_number">
                    <span>Número de producto: </span>{!!isset($shirt->product_number) ? $shirt->product_number : "" !!}
                </div>
            @endif
            @isset($shirt->designer)
                <div class="shirt-specifications-designer">
                    <span>Diseño de: </span>{!!isset($shirt->designer) ? $shirt->designer : "" !!}
                </div>
            @endif
            @isset($shirt->locale['material'])
                <div class="shirt-specifications-material">
                    <span>Material: </span> {!!isset($shirt->locale['material']) ? $shirt->locale['material'] : "" !!}
                </div>
            @endif
            @isset($shirt->category_id)
                <div class="shirt-specifications-material">
                    <span>Categoria: </span> {{$shirt->category_id}}
                    {{-- Tiene que ser el nombre --}}
                </div>
            @endif
        </div>
        <div class="shirt-image">
            @isset($shirt->image_featured_desktop->path)
                <div class="shirt-description-image">
                    <img src="{{Storage::url($shirt->image_featured_desktop->path)}}" alt="{{$shirt->image_featured_desktop->alt}}" title="{{$shirt->image_featured_desktop->title}}" />
                </div>
            @endif
            @isset($shirt->image_grid_desktop)
                <div class="shirt-description-image-grid">
                    @foreach ($shirt->image_grid_desktop as $image)
                        <div class="shirt-description-image-grid-item">
                            <img src="{{Storage::url($image->path)}}" alt="{{$image->alt}}" title="{{$image->title}}" />
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        <div class="shirt-sizes">
            @isset($shirt->shirts_sizes)
                @foreach ($shirt->shirts_sizes as $size)
                    <div class="shirt-size">{{$size->sizes->size}}</div>
                @endforeach
            @endisset
                
        </div>
        <div class="shirt-colours">
            @isset($shirt->shirts_colours)
                @foreach ($shirt->shirts_colours as $colour)
                    <div class="shirt-colour">{{$colour->colours[0]->colour}}S </div>
                @endforeach
            @endisset 
        </div>
    
        <div class="shirt-prices">
            <div class="shirt-final-price">
                {!!isset($shirt->product->price) ? $shirt->product->price : "" !!}
            </div>
            {{-- <div class="shirt-discount">
                {!!isset($shirt->product->discount) ? $shirt->product->discount : "" !!}
            </div>
            <div class="shirt-original-price">
                {!!isset($shirt->product->original_price) ? $shirt->product->original_price : "" !!}
            </div> --}}
        </div>
    </div>
    
</div>
