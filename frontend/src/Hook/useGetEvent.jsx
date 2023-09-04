export default function useGetEvent() {
  return function (id) {
      return fetch(`http://localhost:8245/event/${id}`, {
          method: 'GET',
          mode: "cors"
      })
          .then(data => data.json())
  }
}