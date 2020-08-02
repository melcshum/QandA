export default {
    modify(user, model) {
        return user.id === model.user_id;
    },
    accept(user, answer) {
        console.log("checking accepting answer");
        return user.id === answer.question.user_id;
    }
}
