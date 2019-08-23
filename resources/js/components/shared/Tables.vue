<template>
    <table class="table table-hover">
        <thead>
        <!--         <tr>
                     <th @click="sortBy('name')">Name</th>
                     <th @click="sortBy('email')">Email</th>
                 </tr>-->
        <tr>
            <th @click="sortBy('id')">ID <i v-if="sortKey === 'id'" :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'" class="ic"></i></th>
            <th>Photo</th>
            <th @click="sortBy('name')">Name <i v-if="sortKey === 'name'" :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'" class="ic"></i></th>
            <th @click="sortBy('email')">Email <i v-if="sortKey === 'email'" :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'" class="ic"></i></th>
            <th>Type</th>
            <th>Created At</th>
            <th>Modify</th>
        </tr>
        </thead>
        <tbody>

        <!--       <tr  v-for="user in usersSorted">
                   <td>{{ user.name }}</td>
                   <td>{{ user.email }}</td>
               </tr>-->
        <!--                            <tr v-for="user in users.users.data" :key="user.id">-->
        <tr v-for="user in usersSorted" :key="user.id">
            <td>{{ user.id }}</td>
            <td><img :src="'img/profile/'+user.photo" alt="" style="height: 50px"></td>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td><span class="tag tag-success">{{ user.type | upText }}</span></td>
            <td>{{ user.created_at | customDate }}</td>
            <td>
                <button @click="editModal(user)" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Edit User">
                    <i class="fas fa-user-edit"></i>
                </button>
                /
                <button  @click="deleteUser(user)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete User">
                    <i class="fas fa-user-minus"></i>
                </button>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "Tables",

        props: {
            columns: [],

        }
    }
</script>

<style scoped>

</style>