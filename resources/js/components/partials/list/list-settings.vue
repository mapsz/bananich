<template>
  <div class="modal list-settings-modal fade" :id="'list-settings-modal-'+model" tabindex="-1" role="dialog" aria-labelledby="list-settings-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title list-settings-modal-title">Настройки таблицы</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Keys List -->
          <div>
            <div v-for="(k, i) in keys" :key="i" class="form-check">
              <input 
                v-model="keys[i].active" 
                @change="save()"
                class="form-check-input" 
                type="checkbox"
                :id="k.name+'-input'"
              >
              <label class="form-check-label" :for="k.name+'-input'">
                {{k.caption}}
              </label>
            </div>
          </div>
        </div>
        <!-- Actions -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['p-keys','model'],
  data(){return{
    keys:[],
  }},
  watch: {
    pKeys: {
      handler: function (val, oldVal) {
        this.keys = val;
      },
      deep: true
    }
  },
  mounted(){
    // $('.list-settings-modal').modal('show');
  },
  methods:{
    async save(){
      let r = await this.jugeAx('/config/post',{model:this.model,keys:this.keys},'post');
      if(!r) return;
      // this.$emit('configChanged',this.keys);
      
    }
  },
}
</script>

<style>

</style>