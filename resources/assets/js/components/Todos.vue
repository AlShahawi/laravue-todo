<style>
.completed {
    text-decoration: line-through;
}
.task {
    position: relative;
}
.task-body {
    font-size: 2em;
}
.task:hover .task-actions {
    display: block;
}
.task-actions {
    display: none;
    position: absolute;
    bottom: 6px;
    right: 20px;
    border-color: #d3e0e9;
    border-width: 15px;
    background-color: #fff;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
    padding: 5px;
    transition: visibility 2s;
    -webkit-transition: visibility 2s;
}
.task-colors {
    position: relative;
}
.task-colors div {
    cursor: pointer;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    float: left;
    margin-left: 5px;
    margin-top: 2.5px;
}
.task-colors .black {
    background-color: black;
}
.task-colors .red {
    background-color: red;
}
.task-colors .blue {
    background-color: blue;
}
.task-colors .orange {
    background-color: orange;
}
.task-colors .yellow {
    background-color: yellow;
}
.task-colors .selected {
    width: 30px;
    height: 30px;
    border: 5px solid #ddd;
    margin-top: 0;
}
</style>

<template>
    <div class="loading-inducator" v-show="jobs > 0">
        <!-- Loading inducator -->
        <div class="loader">Loading...</div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="pull-left">
                            Add New Todo Task
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <input @keyup.enter.stop="add"
                                   autofocus type="text"
                                   class="form-control input-lg"
                                   v-model="newTask"
                                   placeholder="New Todo Task...">
                        </div>
                        <div class="task-colors">
                            <div @click="setColor('black')" class="black" :class="{ selected: newTaskColor == 'black'}"></div>
                            <div @click="setColor('red')" class="red" :class="{ selected: newTaskColor == 'red'}"></div>
                            <div @click="setColor('blue')" class="blue" :class="{ selected: newTaskColor == 'blue'}"></div>
                            <div @click="setColor('orange')" class="orange" :class="{ selected: newTaskColor == 'orange'}"></div>
                            <div @click="setColor('yellow')" class="yellow" :class="{ selected: newTaskColor == 'yellow'}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 task" v-for="task of tasks">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="task-body" :style="{ color: task.color }" :class="{ completed: task.completed}">
                            {{ task.body }}
                        </div>
                        <div class="task-actions">
                            <button type="button" @click="toggleCompleted($index, task.id)" class="btn btn-xs task-remove">
                                <span v-show="!task.completed">
                                    <span class="glyphicon glyphicon-ok"></span> done
                                </span>
                                <span v-else>
                                    <span class="glyphicon glyphicon-hourglass"></span> in progress
                                </span>
                            </button>
                            <button type="button" @click="remove($index, task.id)" class="btn btn-xs task-remove">
                                <span class="glyphicon glyphicon-remove"></span> remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2" v-if="!tasks.length && !(jobs > 0)">
                You have no tasks. try add one of them...
            </div>
        </div>
    </div>
</template>

<script>
    import tasksService from '../services/TasksService';

    export default {
        data() {
            return {
                tasks: [],
                newTask: '',
                newTaskColor: 'red',
                jobs: 0
            };
        },
        ready() {
            this.jobs++;
            tasksService.getAll()
                 .then((tasks) => {
                     this.tasks = tasks;
                     this.jobs--;
                 });
        },
        methods: {
            add() {
                if(! this.newTask) return;
                var task = {
                    body: this.newTask,
                    color: this.newTaskColor,
                    completed: false
                };
                this.jobs++;
                tasksService.add(task).then((task) => {
                    this.tasks.unshift(task);
                    this.jobs--;
                });
                this.newTask = '';
            },
            toggleCompleted(index, id) {
                var task = this.tasks[index];
                this.jobs++;
                tasksService.toggle(task).then(() => {
                    task.completed = !task.completed;
                    this.jobs--;
                });
            },
            remove(index, id) {
                console.log('deleting', index);
                var task = this.tasks[index];
                this.jobs++;
                this.tasks.splice(index, 1);
                tasksService.remove(task).then(() => {
                    this.jobs--;
                }).catch((response) => {
                    console.log('error occured while deleting a task.');
                    console.log(response.message, response.code);
                });
            },
            setColor(color) {
                this.newTaskColor = color;
                console.log(color);
            }
        }
    }
</script>
