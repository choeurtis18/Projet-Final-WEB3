export default function useGetMasterclassQuizz() {
    return function (id) {
        return fetch(`http://localhost:8245/masterclass/${id}/quizzes`, {
            method: 'GET',
            mode: "cors"
        }).then(data => data.json())
    }
}