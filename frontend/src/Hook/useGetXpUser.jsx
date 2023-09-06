import useGetCoockie from "./useGetCoockie";

export default function useGetXpUser() {
    const credentials = useGetCoockie("token");

    const fetchXp = async () => {
        try {
            const response = await fetch('http://localhost:8245/users/xp', {
                method: 'GET',
                mode: "cors",
                headers: {
                    'Authorization': `Bearer ${credentials}`
                }
            });

            if (!response.ok) {
                throw new Error("Erreur lors de la récupération de l'XP.");
            }

            return await response.json();
        } catch (error) {
            throw error;
        }
    };

    return fetchXp;
}
