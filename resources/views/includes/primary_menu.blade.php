<div class="primary_menu">

	@auth
		<a href="{{ url('/app') }}" class="{{ request()->is('app') ? 'active' : '' }}"><img src="./img/sidebar_icon1.svg" alt="">Virtualizar</a>
		<a href="{{ url('/history') }}" class="{{ request()->is('history') ? 'active' : '' }}"><img src="./img/sidebar_icon2.svg" alt="">Historial</a>

		<a href="{{ url('templates') }}" class="{{ request()->is('templates', 'template') ? 'active' : '' }}">
			<img src="./img/sidebar_icon4.svg" alt="">Plantillas
		</a>


		<a href="{{ url('/plans') }}" class="{{ request()->is('plans') ? 'active' : '' }}"><img src="./img/sidebar_icon2.svg" alt="">Planes</a>
		<a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}"><img src="./img/sidebar_icon3.svg" alt="">Contactanos</a>
		<a href="{{ url('/account') }}" class="{{ request()->is('account') ? 'active' : '' }}"><img src="./img/sidebar_icon6.svg" alt="">Mi cuenta</a>

		<a href="{{ url('/newPlan') }}" class="{{ request()->is('newPlan') ? 'active' : '' }}"><img src="./img/sidebar_icon2.svg" alt="">Nuevo Plan</a>
		<a href="{{ url('/customize') }}" class="{{ request()->is('customize') ? 'active' : '' }}"><img src="./img/sidebar_icon7.svg" alt="">Personalizar suscripciones</a>
		<a href="{{ url('/createUsers') }}" class="{{ request()->is('createUsers') ? 'active' : '' }}"><img src="./img/sidebar_icon8.svg" alt="">Crear usuarios</a>
		<a href="{{ url('/listUsers') }}" class="{{ request()->is('listUsers') ? 'active' : '' }}"><img src="./img/sidebar_icon9.svg" alt="">Usuarios</a>
	@else
		<a href="{{ url('/plans') }}" class="{{ request()->is('plans') ? 'active' : '' }}"><img src="./img/sidebar_icon2.svg" alt="">Planes</a>
		<a data-bs-toggle="modal" data-bs-target="#login_modal"><img src="./img/sidebar_icon9.svg" alt="">Iniciar Sesión</a>
	@endauth

</div>


