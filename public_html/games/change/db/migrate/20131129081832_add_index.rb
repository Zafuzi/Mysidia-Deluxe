class AddIndex < ActiveRecord::Migration
  def change
    add_index :scores, :score
  end
end
