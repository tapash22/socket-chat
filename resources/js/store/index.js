import axios from "axios"

export default {
    state:{
        userlist:[],
        userMessage:[]
    },

    mutations:{
        USER_LIST(state,payload){
          return state.userlist = payload;
        },

        USER_MESSAGE(state,payload){
            return state.userMessage = payload;
        }
    },
    getters:{
        userList(state){
            return state.userlist;
        },
        userMessage(state){
            return state.userMessage;
        }

    },
    actions:{
        userList(context){
            axios.get('userlist').then(response =>{
                context.commit('USER_LIST',response.data);
            })
        },

        userMessage(context,id){
            axios.get('/userMessage/'+id).then(response =>{
                context.commit('USER_MESSAGE',response.data);
            })
        }
    }
}