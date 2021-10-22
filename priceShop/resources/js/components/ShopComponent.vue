<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <h1 class="my-4">CounterSpell</h1>
                    <div class="list-group">
                        <div class="list-group-item"><p>Foils <input style="display: inline" type="checkbox" value="true" v-model="foil"></p> </div>
                        <div class="list-group-item">
                            <p>Expansion </p>
                            <select style="width:100%;max-width:100%;" name="expansions" id="expansions" v-model="selectedExpansion">
                                <option value="" >Select an Expansion</option>
                                <option v-for="(expansion , expansionShortcut) in expansions" :value="expansionShortcut">{{expansion[0]}}</option>
                            </select>
                        </div>
                        <div class="list-group-item">
                            <p>Quality</p>
                            <input type="radio" name="qualiy" value="nm"  v-model="pickedQuality" v-on:change="changePrice()"> Near Mint<br>
                            <input type="radio" name="qualiy" value="ex"   v-model="pickedQuality" v-on:change="changePrice()"> Excelent<br>

                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row search" >
                        <form @submit="onSearch">
                            <div class="input-group">
                                <input v-model.lazy="search" type="text" class="form-control" placeholder="Search">
                                <div class="input-group-btn">
                                    <button class="btn btn-default search-btn" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="row">

                        <div class="col-lg-4 col-md-6 mb-4" v-for="card in cards" :key="cards.id" >
                            <div class="card h-100 card-parent">
                                <div class="card-display">
                                    <a href="#!"><img class="" :src="card.cardkingdom.link_to_image_little" alt="" /></a>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><a href="#!">{{card.name}}</a></h4>
                                </div>
                                <div class="card-footer"><small class="text-muted">
                                    <h5 >{{ card.price / 100}} {{card.cardkingdom.currency}}</h5>
                                </small></div>
                            </div>
                        </div>

                    </div>
                    <div @click="scrollToTop()" class="col-lg-9 paginationShop">
                        <pagination :data="rawCards"  @pagination-change-page="fetchCards"></pagination>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function(){
           return {
               rawCards : {},
               search: "",
               expansions : {},
               selectedExpansion : "",
               pickedQuality : "nm",
               foil: true


           }
        },
        mounted() {
            this.fetchCards();
            axios.get('/api/expansions')
                .then(response => {
                    this.expansions = response.data;
                });

        },
        methods: {
            fetchCards(page = 1){
                axios.get('/api/cards?page=' + page
                    +"&q=" + this.search
                    +"&expansion=" + this.selectedExpansion
                    +"&foil=" + this.foil

                )
                    .then(response => {
                        console.log(response.data);
                        this.rawCards = response.data;

                    });
            },
            onSearch($event){
                $event.preventDefault();
                this.fetchCards();
            },
            scrollToTop() {
                window.scrollTo(0,0);
            }



        },
        watch: {
            search: function (value) {
                this.fetchCards();
            },
            selectedExpansion: function (value) {
                this.fetchCards();
            },
            foil: function (value) {
                this.fetchCards();

            }

        },
        computed: {
                cards: function () {
                    if(!this.rawCards.data) return [];

                    return this.rawCards.data.map(card => {

                            card.price = this.pickedQuality === "nm" ? card.cardkingdom.price_nm : card.cardkingdom.price_ex ;
                        
                       return card;
                    });

                }
        }
    }
</script>
