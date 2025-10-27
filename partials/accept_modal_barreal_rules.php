<div class="modal fade popup-my_barrel " id="confirm-my_barrel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo __('Condições de Aquisição', 'central-da-cerveja'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-start flex-column justify-content-start p-2 pt-3 ms-4 me-4">
                <div class="ms-3">
                    <p>
                        Olá!!! Que legal que você veio adquirir o seu barril aqui na Central de Cerveja!
                    </p>
                    <p>
                        Mas antes de especificar a sua necessidade, fique atento às condições abaixo, já que elas são fundamentais para que tudo funcione adequadamente.
                    </p>
                </div>
                <div>
                    <ol>
                        <li>Importante esclarecer que você receberá no endereço especificado apenas o barril descartável com a cerveja desejada. Todos os demais itens necessários ficam por sua conta, como por exemplo, chopeira, extratora, cilindro de CO2 e demais apetrechos.</li>
                        <li>A Central da Cerveja irá em busca do seu chope e quando encontrado ele será enviado ao seu endereço mediante pagamento adiantado tanto do barril, quanto do frete.</li>
                        <li>Tenha em mente que a maior parte dos chopes precisam ficar armazenados em ambiente refrigerado até a data da utilização.</li>
                        <li>Por fim, ao fazer a sua cotação, leve em consideração o prazo de entrega em relação à data de quando pretende usar o barril. Dependendo da distância da cervejaria escolhida, esse prazo de entrega pode variar bastante.</li>
                    </ol>
                </div>
               <div  class="ms-3">
                    <p>Tendo em vista estes aspectos, você se declara ciente e de acordo com estas condições?</p>
                    <p><input type="checkbox" id="checkbox_barrel"><label for="checkbox_barrel" id="barrel_accept_conditions">&nbsp;Concordo com as condições.</label></p>
               </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo __('FECHAR', 'central-da-cerveja'); ?></button>
                <a href="javascript:void(0)" type="button" class="btn btn-access my_barrel_clicked"><?php echo __('ACESSAR', 'central-da-cerveja'); ?></a>
            </div>
        </div>
    </div>
</div>