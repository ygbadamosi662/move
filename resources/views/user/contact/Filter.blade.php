<div class="filter">
  <h4>Filter By:</h4>
  <form method="POST" action="{{ route('get_contacts') }}">
    @csrf

    <div class="field">
      <label for="name">Name</label>
      <input type="text" id="name" name="name">
    </div>

    <div class="field">
      <label for="phone">Phone</label>
      <input type="text" id="phone" name="phone">
    </div>

    <div class="field">
      <label for="type">Type:</label>
      <select name="type" id="type">
        <option value="">--Select--</option>
          <option value="home" >Home</option>
          <option value="work">Work</option>
          <option value="other">Other</option>
      </select>
    </div>

    <div class="field">
        <label for="ship">Ship</label>
        <select name="ship" id="ship">
            <option value="">--Select--</option>
            <option value="fam">Fam</option>
            <option value="friend">Friend</option>
            <option value="colleague">Colleague</option>
            <option value="acquaintance">Acquaintance</option>
            <option value="foe">Foe</option>
            <option value="boss">Boss</option>
            <option value="other">Other</option>
        </select>
    </div>

    <button type="submit">Filter</button>
  </form>
</div>
