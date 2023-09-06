export default function useGetEventList() {
  return function () {
      return fetch('http://localhost:8245/events', {
          method: 'GET',
          mode: "cors"
      }).then(data => data.json())
  }
}