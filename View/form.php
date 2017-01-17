<form>
<table class="table table-bordered">

        <tr>
            <th></th>
            <th>Prix</th>
            <th>Distance</th>
            <th>NbEt</th>
        </tr>
        <tr>
            <td>Poids</td>
            <td><input type="text"  id="prix_poids" name="prix_poids" placeholder=""></td>
            <td><input type="text"  id="distance_poids" name="distance_poids" placeholder=""></td>
            <td><input type="text"  id="nbet_poids" name="nbet_poids" placeholder=""></td>
        </tr>
        <tr>
            <td>Préférences</td>
            <td>
                <select id="prix_pref" name="prix_pref" >
                    <option value="MIN">Min</option>
                    <option value="MAX">Max</option>
                </select>
            </td>
            <td>
                <select id="distance_pref" name="distance_pref">
                    <option value="MIN">Min</option>
                    <option value="MAX">Max</option>
                </select>
            </td>
            <td>
                <select id="nbet_pref" name="nbet_pref" >
                    <option value="MIN">Min</option>
                    <option value="MAX">Max</option>
                </select>
            </td>
        </tr>

</table>
<button type="submit" class="btn btn-default">Valider</button>
</form>