<style>
    .slide-fade-enter-active {
        transition: all .3s ease;
    }
    .slide-fade-leave-active {
        transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active below version 2.1.8 */ {
        transform: translateX(10px);
        opacity: 0;
    }
</style>
<div id="demo">
    <button v-on:click="show = !show">
        Permuter
    </button>
    <transition name="slide-fade" >
        <p v-if="show">bonjour</p>
    </transition>

</div>


    <script>
        new Vue({

            el:'#demo',
            data:{
                show: true
            }
        })


    </script>