<div class="container">
    <div class="row justify-content-center pt-4">
        <div class="col-md-8">
            <h1 class="text-center mb-3">Booj Books</h1>
            <div class="d-flex justify-content-between">
                <div>
                    <a class="btn btn-link" href="/books" role="button">Find Books</a>
                    <a class="btn btn-link" href="/list" role="button">My List</a>
                </div>
                <div class="align-self-center">
                    @auth
                        <div class="d-flex">
                            <p class="mr-1 mb-0">{{ auth()->user()->name }} - </p>
                            <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    @endauth
                    @guest
                        <a class="btn btn-link" href="/login" role="button">Login</a>
                        <a class="btn btn-link text-success" href="/register" role="button">Get Started</a>
                    @endguest
                </div>
            </div>
            <hr class="my-0">
        </div>
    </div>
</div>
