--------------------- -- -- -- - -- -- - -------

    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First name</th>
          <th scope="col">Last name</th>
          <th scope="col">Role</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
              <th scope="row"> <?= $user->id ?> </th>
              <td><?= $user->first_name ?> </td>
              <td><?= $user->last_name ?> </td>
              <td><?= $user->name ?> </td>
              <td>
                  <?= $user->is_active ? '<span class="badge bg-success"> active</span>' : '<span class=" badge bg-danger"> blocked</span>' ?> 
                  <?= $user->is_info_confirmed ? '<span class="badge bg-success"> confirmed </span>': '<span class=" badge bg-danger"> not Confirmed</span>' ?>
              </td>
              <td>
                  <a href="/account/user/<?= $user->id ?>" class="badge bg-info"> view</a>      
              </td>
            </tr>
        <?php endforeach; ?>
      </tbody>
    </table>