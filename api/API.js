const URL_API = 'https://tasty.p.rapidapi.com/recipes/list';
const CHAVE_API = 'cfae1091c4msh3f5328510676a5ap1cabd5jsn4672b85d1187'; 

async function buscarReceitasJaponesas() {
    try {
        const resposta = await fetch(`${URL_API}?from=0&size=10&tags=japanese`, {
            method: 'GET',
            headers: {
                'X-RapidAPI-Host': 'tasty.p.rapidapi.com',
                'X-RapidAPI-Key': CHAVE_API
            }
        });

        if (!resposta.ok) {
            throw new Error(`Erro na requisição: ${resposta.status}`);
        }

        const dados = await resposta.json();
        return dados.results || [];
    } catch (erro) {
        console.error('Erro ao buscar receitas:', erro);
    }
}
function exibirReceitas(receitas) {
    const containerReceitas = document.getElementById('recipe-container');
    containerReceitas.innerHTML = ''; // Limpa o container

    receitas.forEach(receita => {
        const elementoReceita = document.createElement('div');
        elementoReceita.classList.add('recipe');

        elementoReceita.innerHTML = `
            <h3 class="text-center">${receita.name}</h3>
            <img src="${receita.thumbnail_url}" alt="${receita.name}">
            <div class="button-container">
                <a href="${receita.original_video_url}" target="_blank" class="btn">Assistir Receita</a>
            </div>
        `;

        containerReceitas.appendChild(elementoReceita);
    });
}

// Chama a função para buscar e exibir receitas
buscarReceitasJaponesas().then(receitas => {
    if (receitas && receitas.length > 0) {
        exibirReceitas(receitas);
    } else {
        console.log('Nenhuma receita encontrada ou erro na requisição.');
    }
}).catch(erro => {
    console.error('Erro ao buscar receitas:', erro);
});
