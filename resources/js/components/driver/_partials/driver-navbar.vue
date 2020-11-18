<template>
<nav class="navbar navbar-expand-lg navbar-light bg-light">  
  <a data-v-04a0d7a8="" href="/driver/deliveries" class="navbar-brand">🚚</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#report-navbar" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="report-navbar">
    <ul class="navbar-nav">
      <li v-for='(link,i) in links' :key='i' :class="current == link.link ? 'active' : ''" class="nav-item">
        <!-- <router-link class="nav-link" :to="link.link">{{link.caption}}</router-link> -->
        <a class="nav-link"  :href="link.link">{{link.caption}}</a>
      </li>
    </ul>
  </div>
</nav>  
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    current:this.$route.path,
  }},
  computed:{
    ...mapGetters({user:'user/getAuth'}),
    ...mapGetters({isAdmin:'user/isAdmin'}),
    links(){
      let links = [
        {
          link:"/driver/deliveries",
          caption:"Выдача",
        },
      ];      
      if(this.isAdmin){
        let adminLinks = [
          {
            link:"/admin/deliveries/all",
            caption:"Выдача все водители",
          }
        ];
        links = adminLinks.concat(links);
      }
      return links;
      
    },

  },
  mounted(){
    //
  },
  methods:{    
    ...mapActions({fetchAuth:'user/fetchAuth'}),
  },
}
</script>

<style>

</style>