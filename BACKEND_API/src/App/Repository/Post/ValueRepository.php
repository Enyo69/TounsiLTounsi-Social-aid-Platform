<?php

/**
 * Ushahidi Post Value Repository
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace Ushahidi\App\Repository\Post;

use Ohanzee\DB;
use Ushahidi\Core\Entity\PostValue;
use Ushahidi\Core\Entity\PostValueRepository as PostValueRepositoryContract;
use Ushahidi\Core\Usecase\Post\ValuesForPostRepository;
use Ushahidi\Core\Usecase\Post\UpdatePostValueRepository;
use Ushahidi\App\Repository\OhanzeeRepository;

abstract class ValueRepository extends OhanzeeRepository implements
    PostValueRepositoryContract,
    ValuesForPostRepository,
    UpdatePostValueRepository
{

    // OhanzeeRepository
    public function getEntity(array $data = null)
    {
        return new PostValue($data);
    }

    // OhanzeeRepository
    public function getSearchFields()
    {
        return [];
    }

    // Override selectQuery to fetch attribute 'key' too
    protected function selectQuery(array $where = [])
    {
        $query = parent::selectQuery($where);

        // Select 'key' too
        $query->select(
            $this->getTable().'.*',
            'form_attributes.key',
            'form_attributes.form_stage_id',
            'form_attributes.response_private'
        )
            ->join('form_attributes')->on('form_attribute_id', '=', 'form_attributes.id');

        return $query;
    }

    // PostValueRepository
    public function get($id, $post_id = null, $form_attribute_id = null)
    {
        $where = array_filter(compact('id', 'post_id', 'form_attribute_id'));
        return $this->getEntity($this->selectOne($where));
    }

    // ValuesForPostRepository
    public function getAllForPost(
        $post_id,
        array $include_attributes = [],
        array $exclude_stages = [],
        $excludePrivateValues = true
    ) {
        $query = $this->selectQuery(compact('post_id'));

        if ($include_attributes) {
            $query->where('form_attributes.key', 'IN', $include_attributes);
        }

        if ($excludePrivateValues) {
            $query->where('form_attributes.response_private', '!=', '1');
            if ($exclude_stages) {
                $query->where('form_attributes.form_stage_id', 'NOT IN', $exclude_stages);
            }
        }

        $results = $query->execute($this->db());

        return $this->getCollection($results->as_array());
    }

    // ValuesForPostRepository
    public function deleteAllForPost($post_id)
    {
        return $this->executeDelete(compact('post_id'));
    }

    // PostValueRepository
    public function getValueQuery($form_attribute_id, array $matches)
    {
        $query = $this->selectQuery(compact('form_attribute_id'))
            ->and_where_open();

        foreach ($matches as $match) {
            $query->or_where('value', 'LIKE', "%$match%");
        }

        $query->and_where_close();

        return $query;
    }

    // PostValueRepository
    public function getValueTable()
    {
        return $this->getTable();
    }

    // UpdatePostValueRepository
    public function createValue($value, $form_attribute_id, $post_id)
    {
        $input = compact('value', 'form_attribute_id', 'post_id');
        $input['created'] = time();

        return $this->executeInsert($input);
    }

    // UpdatePostValueRepository
    public function updateValue($id, $value)
    {
        $update = compact('value');
        if ($id && $update) {
            $this->executeUpdate(compact('id'), $update);
        }
    }

    // UpdatePostValueRepository
    public function deleteNotIn($post_id, array $ids)
    {
        DB::delete($this->getTable())
            ->where('post_id', '=', $post_id)
            ->where('id', 'NOT IN', $ids)
            ->execute($this->db());
    }
}
