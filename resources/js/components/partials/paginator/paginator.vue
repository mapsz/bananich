<template>
  <paginate
    v-if="pages.last_page > 1"
    v-model="page"
    :page-count="pages.last_page"
    :container-class="'pagination m-0'"
    :page-class="'page-item'"
    :prev-class="'page-item'"
    :next-class="'page-item'"
    :page-link-class="'page-link'"
    :prev-link-class="'page-link'"
    :next-link-class="'page-link'"
    :prevText="'&laquo;'"
    :nextText="'&raquo;'"
    :click-handler="change"
    @change="change"
  >
  </paginate>
</template>

<script>
export default {
  props: ['model'],
  data(){return{
    page:0,
  }},
  computed:{
    pages () {
      return this.$store.getters['get'+this.model+'Pages']
    }
  },
  watch: {
    pages: {
      handler: function (val, oldVal) {
        this.page = this.pages.current_page != undefined ? this.pages.current_page : 0;
      },
      deep: true
    }
  },
  methods:{
    change(page){
      //Add query string
      let query = Object.assign({}, this.$route.query);
      query.page = page;
      this.$router.push({ query });
      this.$store.dispatch('fetch'+this.model);
    }
  },
}
</script>

<style>

</style>