<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <tr>
        <td class="centrar">{{index + from}}</td>
        <td>
            <span v-show="!editing" @dblclick="canviaNom(index,todo)">{{ todo.name }}</span>
            <input type="text" v-model="todo.name" v-show="editing" @keyup.enter="canviaNom(index,todo)" v-todo-focus="editing" onfocus="this.select();" @keyup.esc="canceleditName(todo)">
            <span @click="canviaNom(index,todo)"><i class="fa fa-fw fa-pencil" v-show="!editing"></i></span>
            <span @click="canviaNom(index,todo)"><i class="fa fa-fw fa-check bg-green" v-show="editing"></i></span>
            <span @click="canceleditName(todo)"><i class="fa fa-fw fa-close bg-red" v-show="editing"></i></span>
        </td>
        <td class="centrar">
            <div v-show="!editingPri" @dblclick="canviaVisiPrioritat(index,todo)">{{ todo.priority }}</div>
            <input type="text" v-model="todo.priority" v-show="editingPri" @keyup.enter="canviaVisiPrioritat(index,todo)" v-todo-focus="editingPri" onfocus="this.select();" @keyup.esc="canceleditPri(todo)">
        </td>
        <td class="centrar">
            <span v-if="todo.done"><input type="checkbox" class="icheckbox_square-green" checked="" @click="modificaDone(index,todo)"></span>
            <span v-else><input type="checkbox" class="icheckbox_square-green" @click="modificaDone(index,todo)"></span>
        </td>
        <td class="centrar">
            <div class="progress progress-xs active">
                <div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 75%"></div>
            </div>
        </td>
        <td class="centrar">
            <span class="badge bg-yellow">75%</span>
        </td>
        <td class="centrar">
            <button class="btn btn-primary" @click="edittodo(index,todo)"><i class="fa fa-pencil" ></i></button>
            <button class="btn btn-danger" v-on:click=" deletetodo(index,todo.id)"><i class="fa fa-trash-o"></i></button>
        </td>
    </tr>
</template>

<style>
    th {
        text-align: center;
    }
    td.centrar {
        text-align: center;
    }

    input:checked {
        height: 22px;
        width: 22px;
    }
</style>

<script>
  export default {
    props: ['todo', 'index', 'from'],

    data() {
      return {
        editing: false,
        editingPri: false,
        bufferedTodoname: null,
        bufferedTodopri: 0,
      }
    },
    created() {
      console.log('Component created');
    },
    methods: {
      hola: function() {
        console.log("Hola");

      },
      canviaNom: function(index, todo) {
        this.bufferedTodoname = todo.name;
        this.editing = !this.editing;
        if (!this.editing) this.modificaNom(index, todo);

      },
      modificaNom: function(index, todo) {
        this.updateApi(todo);
        console.log(todo);
      },
      updateApi: function(todo) {
        this.$http.put('/api/v1/task/' + todo.id, {
          name: todo.name,
          priority: todo.priority,
          done: todo.done,
        }).then((response) => {
          console.log(response);

        }, (response) => {
          // error callback
          sweetAlert("Oops...", "Something went wrong!", "error");
          console.log(response);
        });
      },
      canviaVisiPrioritat: function(index, todo) {
        this.bufferedTodopri = todo.priority;
        this.editingPri = !this.editingPri;
        if (!this.editingPri) this.modificaPrioritat(index, todo);
      },
      modificaPrioritat: function(index, todo) {
        this.updateApi(todo);
      },
      modificaDone: function(index, todo) {
        todo.done = !todo.done;
        this.updateApi(todo);
      },
      deletetodo: function(index, id) {
        this.$emit('todo-deleted', index, id);
      },
      canceleditName: function(todo) {
        todo.name = this.bufferedTodoname;
        this.editing = false;
      },
      canceleditPri: function(todo) {
        todo.priority = this.bufferedTodopri;
        this.editingPri = false;
      },
      edittodo: function(index, todo) {
        this.canviaVisiPrioritat(index, todo);
        this.canviaNom(index, todo)
      }
    },
    directives: {
      'todo-focus': function(el, value) {
        if (value) {
          el.focus()
        }
      }
    }
  }
</script>
