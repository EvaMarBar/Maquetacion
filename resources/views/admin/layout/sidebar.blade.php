<div class="menu-icon" id="menu-icon">
    <div class="form-1" id="form-1"></div>
    <div class="form-2" id="form-2"></div> 
    <div class="form-3" id="form-3"></div>
</div>

<div class="menu" id="menu">
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

{{-- <div class="menu-icon" onclick="toggleNav(this)">
    <div class="form-1"></div>
    <div class="form-2"></div> 
    <div class="form-3"></div>
  </div>
  <div class="menu" id="slideMenu">
    <div class="nav-section" id="menuText">
        <ul>
            <li class="link-button" data-url="{{route("clients")}}" value="Clientes">
            @lang('admin/clients.parent_section')
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
  --}}