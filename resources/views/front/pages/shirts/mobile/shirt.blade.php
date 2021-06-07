<div class="shirt">
    <div class="row">
        <div class="column column-1">
            <div class="shirt-title">
                <h2>{{isset($shirt->seo->title) ? $shirt->seo->title : ""}}</h2>
            </div>

            <div>
                <div class="shirt-description">
                    <div class="shirt-description-text">
                        {!!isset($shirt->locale['description']) ? $shirt->locale['description'] : "" !!}
                    </div>
                </div>
                <div class="shirt-attributes">
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
                                <div class="shirt-colour">{{$colour->colours[0]->colour}} </div>
                            @endforeach
                        @endisset 
                    </div>
                </div>
                <div class="grid">
                    <div class="shirt-images">
                        @isset($shirt->image_grid_desktop)
                            <div class="shirt-description-image-grid">
                                    <div class="shirt-description-image-grid-item">
                                        <img src="{{Storage::url($shirt->image_grid_desktop->last()->path)}}" alt="{{$shirt->image_grid_desktop->last()->alt}}" title="{{$shirt->image_grid_desktop->last()->title}}" />
                                    </div>
                            </div>
                        @endif
                        <div class="wish-list" id="wish-list">
                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12.1,18.55L12,18.65L11.89,18.55C7.14,14.24 4,11.39 4,8.5C4,6.5 5.5,5 7.5,5C9.04,5 10.54,6 11.07,7.36H12.93C13.46,6 14.96,5 16.5,5C18.5,5 20,6.5 20,8.5C20,11.39 16.86,14.24 12.1,18.55M16.5,3C14.76,3 13.09,3.81 12,5.08C10.91,3.81 9.24,3 7.5,3C4.42,3 2,5.41 2,8.5C2,12.27 5.4,15.36 10.55,20.03L12,21.35L13.45,20.03C18.6,15.36 22,12.27 22,8.5C22,5.41 19.58,3 16.5,3Z" />
                            </svg>
                            <span>Añadir a la lista de deseos</span>
                        </div>
                    </div>
                    <div class="shirt-specifications">
                        @isset($shirt->product_number)
                            <div class="shirt-specification">
                                <span>Número de producto: </span>{!!isset($shirt->product_number) ? $shirt->product_number : "" !!}
                            </div>
                        @endif
                        @isset($shirt->designer)
                            <div class="shirt-specification">
                                <span>Diseño de: </span>{!!isset($shirt->designer) ? $shirt->designer : "" !!}
                            </div>
                        @endif
                        @isset($shirt->locale['material'])
                            <div class="shirt-specification">
                                <span>Material: </span> {!!isset($shirt->locale['material']) ? $shirt->locale['material'] : "" !!}
                            </div>
                        @endif
                        @isset($shirt->category_id)
                            <div class="shirt-specification">
                                <span>Categoria: </span> {{$shirt->category->name}}
                            </div>
                        @endif
                    </div> 
                </div>
                <div class="shirt-prices">
                    <div class="shirt-original-price">
                        <span>{{isset($shirt->product->price) ? sprintf('%.2f', $shirt->product->price*((1+($shirt->product->taxes)/100))) : ""}}€</span>
                    </div>
                    @if($shirt->product->discount != 0)
                        <div class="shirt-discount">
                            
                            <span>Este artículo tiene un {{isset($shirt->product->discount) ? floatval($shirt->product->discount) : ""}}% de descuento</span>
                        </div>
                        <div class="shirt-final-price">
                            <span>{!!isset($shirt->product->price) ? $shirt->product->price : "" !!}€</span>
                        </div>
                        <div class="cross"></div>
                    @endif
                    
                </div>
                <div id="cart" class="cart active">
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M17,18C15.89,18 15,18.89 15,20A2,2 0 0,0 17,22A2,2 0 0,0 19,20C19,18.89 18.1,18 17,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5.5C20.95,5.34 21,5.17 21,5A1,1 0 0,0 20,4H5.21L4.27,2M7,18C5.89,18 5,18.89 5,20A2,2 0 0,0 7,22A2,2 0 0,0 9,20C9,18.89 8.1,18 7,18Z" />
                    </svg>
                    <div>Añadir al carrito</div>
                </div> 
                <div class="cart-added" id="cart-added">
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M17,18C15.89,18 15,18.89 15,20A2,2 0 0,0 17,22A2,2 0 0,0 19,20C19,18.89 18.1,18 17,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5.5C20.95,5.34 21,5.17 21,5A1,1 0 0,0 20,4H5.21L4.27,2M7,18C5.89,18 5,18.89 5,20A2,2 0 0,0 7,22A2,2 0 0,0 9,20C9,18.89 8.1,18 7,18Z" />
                    </svg>
                    <div>Añadido</div>
                </div> 
            </div>
        </div>

        <div class="column column-2">
            <div class="shirt-image-featured">
                @isset($shirt->image_featured_desktop->path)
                    <div class="shirt-description-image">
                        <img src="{{Storage::url($shirt->image_featured_desktop->path)}}" alt="{{$shirt->image_featured_desktop->alt}}" title="{{$shirt->image_featured_desktop->title}}" />
                    </div>
                @endif
            </div>
        </div>
        
    </div>
</div>