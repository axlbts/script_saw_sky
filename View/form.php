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
            <td><input type="text" class="form-control"  id="input-prix" name="prix_poids" placeholder=""></td>
            <td><input type="text" class="form-control"  id="input-distance" name="distance_poids" placeholder=""></td>
            <td><input type="text" class="form-control"  name="nbet_poids" id="input-nbet" placeholder=""></td>
        </tr>
        <tr>
            <td>Préférences</td>
            <td>
                <select class="form-control" id="prix_pref" name="prix_pref" >
                    <option value="MIN">Min</option>
                    <option value="MAX">Max</option>
                </select>
            </td>
            <td>
                <select class="form-control" id="distance_pref" name="distance_pref">
                    <option value="MIN">Min</option>
                    <option value="MAX">Max</option>
                </select>
            </td>
            <td>
                <select class="form-control" id="nbet_pref" name="nbet_pref" >
                    <option value="MIN">Min</option>
                    <option value="MAX">Max</option>
                </select>
            </td>
        </tr>

</table>
<button type="submit" class="btn btn-default">Valider</button>
</form>