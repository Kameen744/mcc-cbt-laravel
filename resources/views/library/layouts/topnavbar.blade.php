<nav class="navbar navbar-expand-sm navbar-dark bg-gradient-primary">

    <button class="navbar-toggler d-lg-none" type="button" 
    data-toggle="collapse" data-target="#collapsibleNavId" 
    aria-controls="collapsibleNavId" aria-expanded="false" 
    aria-label="Toggle navigation">
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ url('/library') }}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/library/resources') }}">Resources</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ url('/library/services') }}">Services</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/library/rules') }}">Rules & Regulations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/library/register') }}">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/library/clearance') }}">Clearance</a> --}}
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/library/admin') }}">Admin</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                <div class="dropdown-menu" aria-labelledby="dropdownId">
                    <a class="dropdown-item" href="#">Action 1</a>
                    <a class="dropdown-item" href="#">Action 2</a>
                </div>
            </li>
        </ul>
        <form class="form-inline mx-4">
            <input class="form-control mr-sm-2" type="text" placeholder="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>