<?php require_once BASE_PATH . '/app/Views/layouts/agent_header.php'; ?>
<?php require_once BASE_PATH . '/app/Views/layouts/agent_sidebar.php'; ?>

<div class="container-fluid px-4 pt-3">
    <h3>
        <?= __('My Tasks') ?></h3>

    <div class="card table-container mt-3">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th><?= __('Task Title') ?></th>
                    <th><?= __('Project') ?></th>
                    <th><?= __('Status') ?></th>
                    <th><?= __('Priority') ?></th>
                    <th><?= __('Due Date') ?></th>
                    <th><?= __('Actions') ?></th>
                </tr>
            </thead>

            <tbody>
            <?php if (!empty($tasks)): ?>
                <?php $i = 1; foreach ($tasks as $t): ?>

                <?php
                    // SAFE VALUES
                    $status   = $t['status'] ?? 'Pending';
                    $priority = $t['priority'] ?? 'Normal';

                    // STATUS BADGE
                    $statusClass =
                        $status === __('Completed')   ? 'bg-success' :
                        ($status === __('In Progress') ? 'bg-primary' : 'bg-warning');

                    // PRIORITY BADGE
                    $priorityClass = match ($priority) {
                        'High'   => 'bg-danger',
                        'Medium' => 'bg-warning text-dark',
                        'Low'    => 'bg-info',
                        default  => 'bg-secondary'
                    };
                ?>

                <tr>
                    <td><?= $i++ ?></td>

                    <td><?= htmlspecialchars($t['title']) ?></td>

                    <td><?= htmlspecialchars($t['project_name'] ?? '—') ?></td>

                    <!-- STATUS -->
                    <td class="text-center">
                        <span class="badge <?= $statusClass ?> px-2 py-1"
                              style="font-size:11px;">
                            <?= $status ?>
                        </span>
                    </td>

                    <!-- PRIORITY -->
                    <td class="text-center">
                        <span class="badge <?= $priorityClass ?> px-2 py-1"
                              style="font-size:11px;">
                            <?= $priority ?>
                        </span>
                    </td>

                    <td><?= !empty($t['due_date']) ? $t['due_date'] : '-' ?></td>

                    <!-- ACTIONS -->
                    <td class="text-center">
                        

                        <?php if ($status !== 'Completed'): ?>
                            <form method="post"
                                  action="<?= BASE_URL ?>/agent/markTaskDone"
                                  class="d-inline">
                                <input type="hidden" name="task_id"
                                       value="<?= $t['id'] ?>">
                                <button type="submit"
                                        class="btn btn-success btn-sm px-2 py-0"
                                        style="font-size:11px;">
                                    <?= __('Mark Done') ?>
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>

                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        <?= __('No tasks assigned yet') ?>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
