<template>
<div>
  <!-- Button -->
  <font-awesome-icon 
    class="list-seetings-button" 
    icon="cog" 
    size="2x" 
    @click="$bvModal.show('list-settings-modal-'+model)" 
  />

  <b-modal :id="'list-settings-modal-'+model" title="Настройки таблицы" ok-only>
    <draggable 
      :list="keys"
      @end="save()"
    >
      <div v-for="(k, i) in keys" :key="i">
        <div class="d-flex m-2 p-2 border" style="cursor: move; align-items: center;">
          <span class="mr-3" style="cursor: move;">📌</span>
          <b-form-checkbox v-model="keys[i].active" @change="save()" switch size="lg" style="cursor: pointer;">
            {{k.label != undefined ? k.label : k.key}}
          </b-form-checkbox>
        </div>
      </div>
    </draggable>
  </b-modal>
</div>
</template>

<script>
export default {
  props: ['p-keys','model'],
  data(){return{
    keys:[],
    positions:[],
  }},
  computed:{
    cKeys: function(){
      let keys = [];
      let key = null;
      $.each(this.keys, ( k, v ) => {
        key = v;
        key.position = k;
        keys.push(key);
      });
      return keys;
    }
  },
  watch: {
    pKeys: {
      handler: function (val, oldVal) {
        this.keys = val;
      },
      deep: true
    }
  },
  methods:{
    async save(){
      let r = await this.jugeAx('/config/post',{model:this.model,keys:this.cKeys},'post');
      if(!r) return;      
    }
  },
}
</script>

<style scoped>
  .list-seetings-button{
    color: #ff9800;
    cursor: pointer;
  }
  .list-seetings-button:hover{
    color: #a6ff36;
  }
</style>