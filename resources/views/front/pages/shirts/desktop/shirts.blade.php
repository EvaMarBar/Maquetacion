@php
    $route = 'shirts';
    $filters = ['search' => true]; 
    $order = ['nombre' => 't_shirts.title', 'categoría' => 't_shirts_categories.name'];
@endphp

<div class="shirts-multiple-title">
        <h2>CAMISETAS</h2>
</div>
<div class="shirts-multiple">
    @foreach ($shirts as $shirt)
        <div class="shirt-multiple" data-content="{{$loop->iteration}}">
            <div class="shirt-multiple-title-container">
                <div class="shirt-multiple-title">
                    <span>{{isset($shirt->seo->title) ? $shirt->seo->title : ""}}</span>
                </div>
            </div>
            <div class="shirt-multiple-image-grid">
                @isset($shirt->image_grid_desktop)
                    <div class="next-photo shirt-description-image-grid">
                        @foreach ($shirt->image_grid_desktop as $image)
                            <div class=" shirt-description-image-grid-item">
                                <img src="{{Storage::url($image->path)}}" alt="{{$image->alt}}" title="{{$image->title}}" />
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="shirt-multiple-prices">
                <div class="shirt-multiple-original-price">
                    <h3>{{isset($shirt->product->price) ? sprintf('%.2f', $shirt->product->price*((1+($shirt->product->taxes)/100))) : ""}}€</h3>
                </div>
                <div class="shirt-link see-more" data-url="{{route("front_product", ['slug' => $shirt->seo->slug])}}">
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M17,13H13V17H11V13H7V11H11V7H13V11H17M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                    </svg>
                </div>
                @if($shirt->product->discount != 0)
                    <div class="shirt-multiple-discount" >
                        
                        <span>-{{isset($shirt->product->discount) ? floatval($shirt->product->discount) : ""}}%</span>
                    </div>
                    <div class="shirt-multiple-final-price">
                        <h3>{!!isset($shirt->product->price) ? $shirt->product->price : "" !!}€</h3>
                    </div>
                    <div class="cross-multiple"></div>
                @endif
                
            </div>
        </div>
    @endforeach
    
</div>
