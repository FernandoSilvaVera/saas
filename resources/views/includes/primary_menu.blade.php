<div class="primary_menu">
	@auth

		@php
			$user = auth()->user();
		@endphp

		{{-- admin --}}
	@if ($user->idProfile === 1)
			<a href="{{ url('/app') }}" class="{{ request()->is('app') ? 'active' : '' }}"><img src="./img/sidebar_icon1.svg" alt="">Virtualizar</a>
			<a href="{{ url('/history') }}" class="{{ request()->is('history') ? 'active' : '' }}"><img src="./img/sidebar_icon2.svg" alt="">Historial</a>


			<a href="{{ url('templates') }}" class="{{ request()->is('templates', 'template') ? 'active' : '' }}">
				<img src="./img/sidebar_icon4.svg" alt="">Plantillas
			</a>

			<a href="{{ url('/listPlans') }}" class="{{ request()->is('listPlans') || request()->is('plan') ? 'active' : '' }}">
				<img src="./img/sidebar_icon2.svg" alt="">Todos los planes
			</a>

			<a href="{{ url('/listUsers') }}" class="{{ request()->is('listUsers') || request()->is('*client*') ? 'active' : '' }}"><img src="./img/sidebar_icon9.svg" alt="">Clientes</a>

			<a href="{{ url('/plans') }}" class="{{ request()->is('plans') ? 'active' : '' }}"><img src="./img/sidebar_icon2.svg" alt="">Planes</a>
			<a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}"><img src="./img/sidebar_icon3.svg" alt="">Contactanos</a>


			<a href="{{ url('/account') }}" class="{{ request()->is('account') ? 'active' : '' }}"><img src="./img/sidebar_icon9.svg" alt="">Mi Cuenta</a>

			<a href="{{ url('/config') }}" class="{{ request()->is('config') ? 'active' : '' }}"><img src="./img/sidebar_icon9.svg" alt="">Configuración</a>

			<a href="{{ url('/logout') }}"><img src="./img/sidebar_icon9.svg">Cerrar Sesión</a>

		@endif

		{{-- client --}}
		@if ($user->idProfile === 2)
			<a href="{{ url('/app') }}" class="{{ request()->is('app') ? 'active' : '' }}"><img src="./img/sidebar_icon1.svg" alt="">Virtualizar</a>
			<a href="{{ url('/history') }}" class="{{ request()->is('history') ? 'active' : '' }}"><img src="./img/sidebar_icon2.svg" alt="">Historial</a>

			<a href="{{ url('templates') }}" class="{{ request()->is('templates', 'template') ? 'active' : '' }}">
				<img src="./img/sidebar_icon4.svg" alt="">Plantillas
			</a>

			<a href="{{ url('/plans') }}" class="{{ request()->is('plans') ? 'active' : '' }}"><img src="./img/sidebar_icon2.svg" alt="">Planes</a>
			<a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}"><img src="./img/sidebar_icon3.svg" alt="">Contactanos</a>
			<a href="{{ url('/shareAccount') }}" class="{{ request()->is('shareAccount') ? 'active' : '' }}"><img src="./img/sidebar_icon9.svg" alt="">Compartir Suscripción</a>
			<a href="{{ url('/account') }}" class="{{ request()->is('account') ? 'active' : '' }}"><img src="./img/sidebar_icon9.svg" alt="">Mi Cuenta</a>
			<a target="_blank" href="https://billing.stripe.com/p/login/test_dR66p43ebbXs6nS288?prefilled_email={{$user->email}}" class="{{ request()->is('config') ? 'active' : '' }}"><img src="./img/sidebar_icon9.svg" alt="">Facturación</a>
			<a href="{{ url('/logout') }}"><img src="./img/sidebar_icon9.svg">Cerrar Sesión</a>
		@endif

	@else
		<a href="{{ url('/plans') }}" class="{{ request()->is('plans') ? 'active' : '' }}"><img src="./img/sidebar_icon2.svg" alt="">Planes</a>
		<a data-bs-toggle="modal" data-bs-target="#login_modal"><img src="./img/sidebar_icon9.svg" alt="">Iniciar Sesión</a>
	@endauth
</div>
