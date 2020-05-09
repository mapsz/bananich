<template>
<div class="d-flex" style="justify-content: space-between;align-items: center;">
  <div>
    Всего: {{pages.total}}
  </div>
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

</div>
</template>

<script>
export default {
props: ['pages'],
data(){return{
  page:this.pages.current_page,
}},
watch: {
  pages: {
    handler: function (val, oldVal) {
      this.page = this.pages.current_page;
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
    this.$emit('paged');
    
    
  }
},
}
</script>

<style>

</style>