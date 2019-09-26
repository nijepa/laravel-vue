<template>
    <div class="col-lg-6 col-6">
        <div class="card">
            <div class="card-header ui-sortable-handle" >
                <h3 class="card-title">
                    <i class="fas fa-comments"></i>
                    Messenger
                </h3>
            </div>
            <div class="card-body">
                <div class="chat-app">
                    <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage"></Conversation>
                    <ContactsList :onlineContacts="onlineContacts" :contacts="contacts" @selected="startConversationWith"></ContactsList>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Conversation from './Conversation';
    import ContactsList from './ContactsList';

    export default {
        name: "Chat",

        components: {
            Conversation, ContactsList
        },

        props: {
            user: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                selectedContact: null,
                messages: [],
                contacts: [],
                onlineContacts: []
            }
        },

        methods: {
            startConversationWith(contact) {
                this.updateUnreadCount(contact, true);

                axios.get(`../api/message/${contact.id}`)
                    .then((response) => {
                        this.messages = response.data;
                        this.selectedContact = contact;
                    })
            },

            saveNewMessage(text) {
                this.messages.push(text);
            },

            hanleIncoming(message) {
                if (this.selectedContact && message.from == this.selectedContact.id) {
                    this.saveNewMessage(message);
                    return;
                }
                this.updateUnreadCount(message.from_contact, false);
            },

            updateUnreadCount(contact, reset) {
                this.contacts = this.contacts.map((single) => {
                    if (single.id !== contact.id) {
                        return single;
                    }
                    if (reset)
                        single.unread = 0;
                    else
                        single.unread += 1;
                    return single;
                })
            }
        },

        mounted() {
            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    this.hanleIncoming(e.message);
                });

            axios.get('../api/chatContact')
                .then((response) => {
                    this.contacts = response.data;
                });

        },

        created() {
            Echo.join(`chat`)
                .here((users) => {
                    console.log('online', users);
                    this.onlineContacts = users;
                })
                .joining((user) => {
                    console.log(user.name);
                    this.onlineContacts.push(user);
                })
                .leaving((user) => {
                    console.log(user.name);
                    this.onlineContacts.splice(this.onlineContacts.indexOf(user), 1);
                });
        }
    }
</script>

<style lang="scss" scoped>
    .chat-app {
        display: flex;
    }
</style>