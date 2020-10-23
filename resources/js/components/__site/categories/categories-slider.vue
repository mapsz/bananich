<template>

            <carousel :per-page="2">
              <slide>
                Slide 1 Content
              </slide>
              <slide>
                Slide 2 Content
              </slide>
              <slide>
                Slide 1 Content
              </slide>
              <slide>
                Slide 2 Content
              </slide>
              <slide>
                Slide 1 Content
              </slide>
              <slide>
                Slide 2 Content
              </slide>
            </carousel>      
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
import { Carousel, Slide } from 'vue-carousel';
export default {
  components: {Carousel,Slide},
  computed:{
    ...mapGetters({
      categories:'category/get',
      active:'category/getActive',
    }),
  },
}
</script>

<style>

</style>