<div class="menu" id="menu">
    <div class="menu-button" id="menu-button">
        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
            <path fill="currentColor" d="M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z" />
        </svg>
    </div>
    <div class="sidebar" id="sidebar">
        <ul>
            <li class="link-button"  data-url="{{route("faqs")}}" id="FAQ's">
                @lang('admin/faqs.parent_section')
            </li>
            <li class="link-button" data-url="{{route("faqs_category")}}" value="Categorias de FAQ's">
                Categorias Faqs
            </li>
            <li class="link-button" data-url="{{route("users")}}" value="Usuarios">
                Usuarios
            </li>
            <li class="link-button" data-url="{{route("clients")}}" value="Clientes">
                @lang('admin/clients.parent_section')
            </li>
        </ul>
    </div>
</div>