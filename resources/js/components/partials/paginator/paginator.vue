<template>
  <paginate
    v-if="pages != undefined && pages.last_page > 1"
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
  props: ['pages'],
  data(){return{
    page:0,
  }},
  watch: {
    pages: {
      handler: function (val, oldVal) {
        this.page = this.pages.current_page != undefined ? this.pages.current_page : 0;
      },
      deep: true
    },
    page: function(val, oldVal){
      //Add query string
      let query = Object.assign({}, this.$route.query);
      if(query.page != undefined && query.page == val) return;
      query.page = val;
      this.$router.push({ query });
    }
  },
  methods:{
    change(page){
      this.$emit('change');
    }
  },
}
</script>

<style>

</style>