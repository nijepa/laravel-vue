<template>
    <table class="table table-hover">
        <thead>

        <tr v-for="column in columns" :key="id">
            <th v-if="sortable.includes(column) ? `<i v-if='sortKey === column' :class='sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'' class='ic'></i>`" : "">{{ column }}</th>
        </tr>

        </thead>
        <tbody>

        <tr v-for="item in model" :key="item.id">
            <td>{{ item.id }}</td>
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
            sortable: [],
            model: [],
            fields: []

        }
    }
</script>

<style scoped>

</style>