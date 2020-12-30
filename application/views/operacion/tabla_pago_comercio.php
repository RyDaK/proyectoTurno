                                <tbody>	
                                    <?foreach($metodo_pago_comercio as $row){?>
                                        <tr>
                                            <td><li onclick="Comercios.eliminar_metodo_fila(<?=$row->id_metodo_pago_comercio?>)" class="fas fa-trash"></li></td>
                                            <td data-idpag=<?=$row->id_metodo_pag?>><?=$row->nombre?></td>
                                        </tr>
                                        <?}?>
                                </tbody>