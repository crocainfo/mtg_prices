<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <h1 class="my-4">CounterSpell</h1>
                    <div class="list-group">
                        <a class="list-group-item" href="#!">Foils</a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row search" >
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search">
                                <div class="input-group-btn">
                                    <button class="btn btn-default search-btn" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 card-parent">
                                <div class="card-display">
                                    <a href="#!"><img class="" src="https://www.cardkingdom.com/images/magic-the-gathering/odyssey/abandoned-outpost-13986-thumb.jpg" alt="" /></a>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><a href="#!">Item One</a></h4>
                                    <h5>$24.99</h5>
                                </div>
                                <div class="card-footer"><small class="text-muted">★ ★ ★ ★ ☆</small></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 card-parent">
                                <div class="card-display">
                                    <a href="#!"><img class="" src="https://www.cardkingdom.com/images/magic-the-gathering/odyssey/abandoned-outpost-13986-thumb.jpg" alt="" /></a>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><a href="#!">Item One</a></h4>
                                    <h5>$24.99</h5>
                                </div>
                                <div class="card-footer"><small class="text-muted">★ ★ ★ ★ ☆</small></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
