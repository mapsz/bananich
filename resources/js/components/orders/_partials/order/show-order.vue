<template>
<div class="container-fluid"> 

  <h3>Заказ #{{order.id}}</h3>
  
  <div class="row">
    <!-- Client -->
    <div class="col-12 col-md-4 order-container">
      <div class="order-inner-container">   
        <show-user :id="order.customer_id"></show-user>
      </div>
    </div>
    <!-- Order details -->
    <div class="col-12 col-md-4 order-details order-container">
      <div class="order-inner-container">
        <span class="d-flex justify-content-between">
          <h5>Детали Заказа</h5>
          <font-awesome-icon 
            @click="editDetails = !editDetails"
            class="mr-3" 
            icon="edit" 
            color="#ff8d00"
            style="cursor:pointer"
          />
        </span>
        <!-- Data -->
        <div v-if="!editDetails">
          <div>{{order.name}} {{order.phone}} {{order.email}}</div>
          <div>
            {{order.address}}
            <span v-if="order.appart">кв. {{order.appart}}</span>  
            <span v-if="order.porch">пд. {{order.porch}}</span>  
          </div>
          <div>{{order.delivery_date}}</div>
          <div>{{delivery_time}}</div>
          <div>{{order.confirm == 1 ? 'Потверждение по телефону' : 'Потверждение по почте'}}</div>
          <div v-if="order.comment">Комментарий клиент: {{order.comment}}</div>          
          <div v-if="order.comment_our">Комментарий бананыч: {{order.comment_our}}</div>
          <div>{{order.created_at}}</div>
        </div>
        <!-- Edit data -->
        <div v-if="editDetails">
          <form id="order-details">
            <!-- Name -->
            <div class="form-group">
              <label for="order-details-name">Имя</label>
              <input name="name" type="text" class="form-control" id="order-details-name" :value="order.name">
            </div>
            <!-- Phone -->
            <div class="form-group">
              <label for="order-details-phone">Телефон</label>
              <input name="phone" type="text" class="form-control" id="order-details-phone" :value="order.phone">
            </div>
            <!-- Email -->
            <div class="form-group">
              <label for="order-details-email">Email</label>
              <input name="email" type="text" class="form-control" id="order-details-email" :value="order.email">
            </div>
            <!-- Address -->
            <div class="form-group">
              <label for="order-details-address">Адрес</label>
              <input name="address" type="text" class="form-control" id="order-details-address" :value="order.address">
            </div>
            <!-- Delivery_date -->
            <div class="form-group">
              <label for="order-details-delivery_date">Дата доставки</label>
              <input name="delivery_date" type="text" class="form-control" id="order-details-delivery_date" :value="order.delivery_date">
            </div>
            <!-- Delivery_time_from -->
            <div class="form-group">
              <label for="order-details-delivery_time_from">Время доставки от</label>
              <input name="delivery_time_from" type="text" class="form-control" id="order-details-delivery_time_from" :value="order.delivery_time_from">
            </div>
            <!-- Delivery_time_to -->
            <div class="form-group">
              <label for="order-details-delivery_time_to">Время доставки до</label>
              <input name="delivery_time_to" type="text" class="form-control" id="order-details-delivery_time_to" :value="order.delivery_time_to">
            </div>
            <!-- Comment -->
            <div class="form-group">
              <label for="order-details-comment">Коммент клиент</label>
              <input name="comment" type="text" class="form-control" id="order-details-comment" :value="order.comment">
            </div>
            <!-- Comment our-->
            <div class="form-group">
              <label for="order-details-comment-our">Коммент бананыч</label>
              <input name="comment_our" type="text" class="form-control" id="order-details-comment-our" :value="order.comment_our">
            </div>
          </form>          
          <button @click="postOrder()" class="btn-success btn">Сохранить</button>
        </div>
      </div>
    </div>
    <!-- Items List -->
    <div class="col-12 col-md-4 order-container">
      <div v-if="order.items" class="order-inner-container"> 
        <h5>Список продуктов</h5>
        <div class="row justify-content-between m-0">
          <span class="align-self-center">
            Всего: {{order.items.length}}
          </span>
          <a class="" data-toggle="collapse" href="#order-items" role="button" aria-expanded="false" aria-controls="collapseExample">
            <font-awesome-icon icon="bars" size="2x"/> 
          </a>       
        </div> 
        <div class="collapse" :class="itemsShow" id="order-items">
          <div class="items-list col-12 p-0" >            
            <div class="m-2 align-self-center">
              <!-- List buttons -->
              <div v-if="!itemEdit && !itemAdd"  class="list-actions">
                <button @click="itemEdit = true" class="btn btn-sm btn-warning">
                  Изминить
                </button>
                <button  @click="itemAdd = true" class="btn btn-sm btn-success">
                  Добавить
                </button>                
              </div>
              <!-- Edit buttons -->
              <div v-if="itemEdit" class="edit-actions">
                <button  @click="itemEdit = false" class="btn btn-sm btn-primary">
                  Просмотр
                </button>
              </div>
              <!-- Add buttons -->
              <div v-if="itemAdd" class="add-action">
                <button @click="itemAdd = false" class="btn btn-sm btn-primary">
                  Просмотр
                </button>
              </div>  
            </div>
            <!-- Items List-->
            <div v-if="!itemAdd" class="items-list">
              <div v-for="(item) in order.items" :key="item.id" class="item">
                <!-- View -->
                <div v-if="!itemEdit && !itemAdd">
                  <show-items
                    :item="item" 
                  ></show-items>
                </div>
                <!-- Edit -->
                <div v-if="itemEdit">
                  <edit-items 
                    :p-item="item" 
                    :p-used-discount="order.discounts.filter(x => x.product_id == item.product_id)"
                    :class="item.id == justAdded ? 'item-just-added' : ''"
                    @item-deleted="itemDeleted"
                    @item-edited="itemEdited"
                    @discount-edited="discountEdited"
                  ></edit-items>
                </div>   
              </div>
            </div>
            <!-- Add items -->
            <div v-if="itemAdd" class="items-add">
              <add-items :p-order-id="id" @item-added="itemAdded"></add-items>
            </div>
          </div>  
        </div>    
      </div>      
    </div>
  </div>

  <div class="row">
    <!-- Order Statuses -->
    <div class="col-12 col-md-4 order-container">
      <div class="order-inner-container"> 
        <order-statuses></order-statuses>
      </div>
    </div>
    <!-- ??? -->
    <div class="col-12 col-md-4 ">      
    </div>
    <!-- Checkout -->
    <div class="col-12 col-md-4 order-container">
      <div class="order-inner-container">
        <div class="d-flex justify-content-between">
          <h4>Итоги</h4>
          <font-awesome-icon 
            @click="editCheckout = !editCheckout"
            class="mr-3" 
            icon="edit" 
            color="#ff8d00"
            style="cursor:pointer"
          />
        </div>
        <show-checkout v-if="!editCheckout" :order="order"></show-checkout>
        <edit-checkout 
          v-else 
          :p-shipping="order.shipping" 
          :p-bonus="order.bonus" 
          :p-order-id="order.id" 
          @checkout-edited="checkoutEdited"
        ></edit-checkout>
      </div>
    </div>
  </div>

</div>
</template>

<script>
import {mapGetters,mapActions} from 'vuex';
export default {
  data(){return{
    id:this.$route.params.id,
    editDetails:false,
    editCheckout:false,
    itemEdit:false,
    itemAdd:false,
    itemsShow:'',
    justAdded:false,
  }},
  computed:{
    ...mapGetters({order:'order/getOne'}),
    delivery_time:function(){
      if(this.order.delivery_time_from == undefined || this.order.delivery_time_from == undefined) return "";
      return this.order.delivery_time_from.slice(0,2)+ ' - ' +this.order.delivery_time_to.slice(0,2)
    },
  },
  async mounted(){
    await this.fetchOne(this.id);
  },  
  methods:{
    ...mapActions({fetchOne:'order/fetchOne'}),
    //Order
    async getOrder(){
      this.fetchOne(this.id);
      // let r = await this.jugeAx('/json/orders',{id:this.id,discounts:true});
      // if(!r) return;

      // this.order = r;
      // this.statuses = r.statuses;
      return;
    },
    async postOrder(){
      let serialize = $('#order-details').serializeArray();
      let r = await this.jugeAx('/order',{serialize:serialize,id:this.id},'post');
      if(!r) return false;
      this.editDetails = false;
      this.getOrder();
    },
    //Statuses
    async getStatusUsers(){
      let userIds = [];
      $.each( this.statuses, ( k, v ) => {        
        userIds.push(v.pivot.user_id);
      });

      //Get
      let r = await this.jugeAx('/json/users',{userIds:userIds});
      if(!r) return;

      $.each( this.statuses, ( k, s ) => {
        $.each( r, ( uk, u ) => {
          if(s.pivot.user_id == u.id){
            this.statuses[k].user = u;
          }
        });
      });

      this.statusesLoad = true;      

    },
    async statusEdited(){
      await this.getOrder();
      await this.getStatusUsers();
      this.editStatus = false;
    },       
    //Items
    itemAdded(item){
      //Add Item
      this.order.items = [item].concat(this.order.items);
      //Goto item edit
      this.justAdded = item.id;
      this.itemAdd = false;
      this.itemEdit = true;
    },
    itemDeleted(itemId){
      //Find item
      let i = this.order.items.findIndex(x => x.id == itemId);
      //Remove item
      this.order.items.splice(i,1);
    },
    itemEdited(item){
      console.log(item);      
    },
    discountEdited(discounts){
      this.order.discounts = discounts;
    },
    //Checkout
    async checkoutEdited(){
      await this.getOrder();
      this.editCheckout = false;
    },    
  }




}
</script>

<style scoped>
.item-just-added{
  background-color: #ebfbeb;
}
.items-list{
  border: 2px dashed;
  border-left: 0px;
  border-right: 0px;
}
.item{
  border-bottom:1px solid gray;
}
.item:last-child{
  border-bottom:0px;
}


.order-details div{
  padding-bottom:10px;
}
.order-container{
  padding:5px;
}

.order-container .order-inner-container{
  border:1px solid black;
  padding:5px;
  border-radius:10px;
}
</style>