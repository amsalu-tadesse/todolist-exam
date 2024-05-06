<template>
  <div class="list">
    <h2>Task List</h2>

    <div class="add-task">
      <input type="text" v-model="newTaskTitle" placeholder="Enter task title" class="task-input">
      <input type="datetime-local" v-model="newTaskDeadline" class="task-input">
      <button @click="addTask" class="add-task-btn">Add Task</button>
    </div>

    <ul class="task-list">
      
      <li v-for="task in tasks" :key="task.id" class="task-item">
        <input type="checkbox" class="task-checkbox" @click="updateTaskStatus(task)">
        <span class="task-title">{{ task.title }}</span>
      </li>
    </ul>

    <h2>Completed Task List</h2>
    <ul class="completed-task-list">
      <li v-for="task in completedTasks" :key="task.id" class="task-item">
        <input type="checkbox" class="task-checkbox" checked disabled>
        <span class="task-title">{{ task.title }}</span>
      </li>
    </ul>
  </div>
</template>

<style>
.add-task {
  display: flex;
  align-items: center;
  margin-top: 20px;
}

.task-input {
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 3px;
  margin-right: 10px;
  font-size: 14px;
}

.add-task-btn {
  padding: 5px 10px;
  background-color: #4caf50;
  color: #fff;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  font-size: 14px;
}

.add-task-btn:hover {
  background-color: #45a049;
}

.add-task-btn:active {
  background-color: #3c903d;
}
 
.add-task {
  margin-bottom: 30px;
}
.task-list,
.completed-task-list {
  list-style-type: none;
  padding: 0;
}
.list {
  margin-left: 200px;
  margin-right: 200px;
  margin-top: 100px;
}
.task-item {
  margin-bottom: 10px;
  border: 1px solid #cccccc;
  padding: 10px;
  background-color: #13612c;
  display: flex;
  align-items: center;
}
.task-checkbox {
  margin-right: 10px;
}
.task-title {
  font-weight: bold;
  margin-left: 5px;
}
</style>

<script>
export default {
  data() {
    return {
      tasks: [],
      completedTasks: [],
    };
  },
  mounted() {
    this.fetchTasks();
  },
  methods: {
    fetchTasks() {
      // Make an HTTP request to fetch the tasks from the backend endpoint
      fetch('http://127.0.0.1:8080/api/tasks')
        .then(response => {
          // Parse the response as JSON
          return response.json();
        })
        .then(data => {
          // Extract the Hydra member from the response
          const hydraMember = data['hydra:member'];
          
          // Check if the Hydra member exists and set the tasks data
          if (hydraMember) {

            console.log(hydraMember);
  this.tasks = hydraMember.filter(task => task.status == 0);
  this.completedTasks = hydraMember.filter(task => task.status == 1);
  console.log(this.completedTasks);
} else {
  console.error('Hydra member not found in the response');
}
        })
        .catch(error => {
          console.error('Error fetching tasks:', error);
        });
    },
    updateTaskStatus(task) {
      // Make an HTTP request to update the task status
      fetch(`http://127.0.0.1:8080/api/tasks/${task.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ status: true }),
      })
        .then(response => {
          if (response.ok) {
            // Move the task from the tasks list to the completedTasks list
            this.tasks = this.tasks.filter(t => t.id !== task.id);
          //  this.completedTasks.push(task);
            this.completedTasks.unshift(task);

          } else {
            console.error('Failed to update task status');
          }
        })
        .catch(error => {
          console.error('Error updating task status:', error);
        });
    },

    addTask() {
      // Make an HTTP request to add a new task
      fetch(`http://127.0.0.1:8080/api/tasks`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ title: this.newTaskTitle, status: false }),
      })
        .then(response => {
          if (response.ok) {
            // Clear the input and fetch the updated task list
            this.newTaskTitle = '';
            this.fetchTasks();
          } else {
            console.error('Failed to add new task');
          }
        })
        .catch(error => {
          console.error('Error adding new task:', error);
        });
    },


  },
};
</script>