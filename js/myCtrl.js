
app.controller('myCtrl', function($scope, $http) {
    $scope.init = function() {
        // Fetch tasks from the database
        $http.get('get_tasks.php')
            .then(function(response) {
                $scope.tasks = response.data;
                console.log('Tasks:', $scope.tasks);
            })
            .catch(function(error) {
                console.error('Error fetching tasks:', error);
            });
            $scope.getTaskCounts();
        $scope.newTask = '';
        $scope.show = 'All';
        $scope.priority = 'High';
        $scope.disableAdd = false;
    };

    $scope.getTasks = function() {
        $http.get('get_tasks.php')
        .then(function(response) {
            $scope.tasks = response.data;
            $scope.tasks.forEach(function(task) {
                task.isDone = task.status === 'completed';
            });
        })
        .catch(function(error) {
            console.error('Error fetching tasks:', error);
        });
    };

    $scope.getTaskCounts = function() {
        $http({
            method: 'GET',
            url: 'get_task_counts.php'
        }).then(function successCallback(response) {
            $scope.cHigh = response.data.high;
            $scope.cMedium = response.data.medium;
            $scope.cLow = response.data.low;
        }, function errorCallback(response) {
            console.error('Error: ', response);
        });
    };
    

    $scope.addTask = function() {
        $scope.disableAdd = true;
        if ($scope.newTask != '') {
            var formData = {
                title: $scope.newTask,
                priority: $scope.priority,
                status: 'pending'
            };
            
            $http.post('add_task.php', formData)
                .then(function(response) {
                    // Add the new task to the tasks array
                    var newTask = response.data;
                    // newTask.isDone = false; // Make sure isDone is set to false
                    $scope.tasks.push(newTask);
                    $scope.newTask = '';
                })
                .catch(function(error) {
                    console.error('Error adding task:', error);
                })
                .finally(function() {
                    $scope.disableAdd = false;
                });
        }
        $scope.getTaskCounts();
    };
    

    // $scope.deleteTask = function(task) {
    //     $scope.disableAdd = true;
    //     var index = $scope.tasks.indexOf(task);
    //     if (index != -1) {
    //         // Remove task from the tasks array
    //         $scope.tasks.splice(index, 1);
    //         // Send request to the server to delete the task from the database
    //         $http.post('delete_task.php', {taskId: task.id})
    //             .then(function(response) {
    //                 // Handle the response if needed
    //             })
    //             .catch(function(error) {
    //                 console.error('Error deleting task:', error);
    //             })
    //             .finally(function() {
    //                 $scope.disableAdd = false;
    //             });
    //     }
    // };

    $scope.deleteTask = function(task) {
        $http({
            method: 'POST', // If your server is set up to use DELETE, change this to 'DELETE'
            url: 'delete_task.php',
            data: { taskId: task.task_id }
        }).then(function successCallback(response) {
            // Remove the task from the tasks array on successful deletion
            var index = $scope.tasks.indexOf(task);
            if (index !== -1) {
                $scope.tasks.splice(index, 1);
            }
        }, function errorCallback(response) {
            // Handle error
            console.log("Error: ", response);
        });
        $scope.getTaskCounts();
    };
    


    $scope.priorityFn = function(x) {
        if ($scope.priority === 'High' && x.priority === 'High')
            return true;
        else if ($scope.priority === 'Medium' && x.priority === 'Medium')
            return true;
        else if ($scope.priority === 'Low' && x.priority === 'Low')
            return true;
        else
            return false;
    };


    $scope.showFn = function(x) {
        if ($scope.show == 'All')
            return true;
        else if (x.status === 'completed' && $scope.show === 'Complete')
            return true;
        else if (x.status === 'pending' && $scope.show === 'Pending')
            return true;
        else
            return false;
    };
  

    // $scope.toggleStatus = function(task) {
    //     var newStatus = task.status === 'completed' ? 'pending' : 'completed';
    //     $http.post('toggle_task.php', { taskId: task.task_id, status: newStatus })
    //     .then(function(response) {
    //         task.status = newStatus;
    //     })
    //     .catch(function(error) {
    //         console.error('Error updating task status:', error);
    //     });
    // };

    // Inside your AngularJS controller
$scope.toggleStatus = function(task) {
    // Prepare the data to be sent to the server
    var data = {
        taskId: task.task_id,
        status: task.status === 'completed' ? 'pending' : 'completed'
    };

    // Send the data to the server using the $http service
    $http.post('toggle_task.php', data)
        .then(function(response) {
            // Handle success response
            console.log('Task status updated:', response.data);
        }, function(error) {
            // Handle error response
            console.error('Error updating task status:', error);
        });
};

    
    
    // Initialize the controller
    $scope.init();
});
