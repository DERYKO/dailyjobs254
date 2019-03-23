<template>
    <div class="col-md-12">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#"><i class="fas fa-igloo fa-lg"> Home</i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                </ul>
                <form class="form-inline my-2 my-lg-0 pull-right">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
        <div class="col-md-3">
            <ul style="list-style: none; padding: 6%">
                <li><router-link tag="li" to="/profile"><a class="btn btn-primary">Profile</a></router-link></li>
                <li><router-link tag="li" to="/view-jobs"><a class="btn btn-primary active">Jobs</a></router-link></li>
                <li><router-link tag="li" to="/post-job"><a class="btn btn-primary">Post Job</a></router-link></li>
                <li><router-link tag="li" to="/account"><a class="btn btn-primary">Account</a></router-link></li>
            </ul>
        </div>
        <div class="col-md-9">
            <router-view ></router-view>
        </div>
    </div>
</template>
<script>
    export default {

    }

</script>